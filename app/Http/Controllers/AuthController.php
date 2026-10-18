<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin(Request $request)
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin()
                ? redirect()->route('admin.dashboard')
                : redirect()->route('peminjam.dashboard');
        }

        $demo = strtolower((string) $request->query('demo'));
        $defaultLogin = match ($demo) {
            'admin' => 'admin@siruka.ac.id',
            'mahasiswa', 'peminjam', 'user' => 'alya@siruka.ac.id',
            default => old('login', old('email', (string) $request->session()->get('registered_login', ''))),
        };
        $defaultPassword = $demo ? 'password' : '';

        return view('auth.login', [
            'defaultLogin' => $defaultLogin,
            'defaultEmail' => $defaultLogin,
            'defaultPassword' => $defaultPassword,
            'selectedDemo' => $demo,
        ]);
    }

    public function login(Request $request)
    {
        $loginInput = trim((string) ($request->input('login') ?? $request->input('email', '')));
        $password = (string) $request->input('password', '');
        $remember = $request->boolean('remember');

        $request->merge(['login' => $loginInput]);
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'Email atau NIM wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        // Attempt login with Email or NIM/NIP
        $isEmail = filter_var($loginInput, FILTER_VALIDATE_EMAIL);
        $credentials = $isEmail
            ? ['email' => $loginInput, 'password' => $password]
            : ['nim_nip' => $loginInput, 'password' => $password];

        $authenticated = Auth::attempt($credentials, $remember);

        if (! $authenticated) {
            $user = User::where('email', $loginInput)
                ->orWhere('nim_nip', $loginInput)
                ->first();

            if ($user && Hash::check($password, $user->password)) {
                Auth::login($user, $remember);
                $authenticated = true;
            }
        }

        if ($authenticated) {
            $request->session()->regenerate();

            /** @var User $user */
            $user = Auth::user();

            if ($user->isAdmin()) {
                // If intended URL was a peminjam/user route, clear it so admin goes to admin dashboard
                $intended = session()->get('url.intended');
                if ($intended && (str_contains($intended, '/peminjam') || str_contains($intended, '/user'))) {
                    session()->forget('url.intended');
                }

                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Selamat datang kembali, Administrator '.$user->name.'!');
            }

            // Clear admin destinations before redirecting a regular user.
            $intended = session()->get('url.intended');
            if ($intended && str_contains($intended, '/admin')) {
                session()->forget('url.intended');
            }

            return redirect()->intended(route('peminjam.dashboard'))
                ->with('success', 'Selamat datang kembali, '.$user->name.'!');
        }

        return back()->withErrors([
            'login' => 'Email/NIM atau kata sandi yang Anda masukkan salah.',
            'email' => 'Email/NIM atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('login', 'email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin()
                ? redirect()->route('admin.dashboard')
                : redirect()->route('peminjam.dashboard');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'nim_nip' => ['required', 'string', 'max:50'],
            'no_hp' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'nim_nip.required' => 'NIM (Nomor Induk Mahasiswa) wajib diisi.',
            'no_hp.required' => 'Nomor WhatsApp / HP wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal terdiri dari 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nim_nip' => $validated['nim_nip'],
            'no_hp' => $validated['no_hp'],
            'role' => 'peminjam',
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('login')
            ->with('success', 'Pendaftaran berhasil. Silakan masuk menggunakan akun yang baru Anda daftarkan.')
            ->with('registered_login', $user->email);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}
