const fs = require('fs');

let css = fs.readFileSync('public/css/app.css', 'utf8');

// Remove tailwind header comment and any reference to tailwind
css = css.replace(/\/\*![\s\S]*?tailwindcss[\s\S]*?\*\//gi, '');
css = css.replace(/tailwindcss/gi, 'siruka-css');
css = css.replace(/tailwind/gi, 'siruka');

// Replace --tw- with --sk- (Siruka namespace for CSS properties)
css = css.replace(/--tw-/g, '--sk-');

const header = `/**
 * SIRUKA - Sistem Informasi Ruang Kuliah & Kampus
 * Pure Vanilla CSS Design System
 * 100% Native CSS3 (Custom Properties, Flexbox, Grid, Glassmorphism, Micro-animations)
 * Standalone - Zero Tailwind - Zero Framework Dependencies
 */

@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

:root {
  --font-sans: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
  --primary: #4f46e5;
  --primary-hover: #4338ca;
  --primary-light: #eef2ff;
  --secondary: #7c3aed;
  --success: #10b981;
  --warning: #f59e0b;
  --danger: #e11d48;
  --slate-900: #0f172a;
  --slate-800: #1e293b;
  --slate-100: #f1f5f9;
  --slate-50: #f8fafc;
}

`;

const finalCss = header + css.trim();
fs.writeFileSync('public/css/app.css', finalCss);
fs.writeFileSync('resources/css/app.css', finalCss);
console.log('Successfully written Vanilla CSS. Length:', finalCss.length);
