/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      spacing: {
        '2': '0.5rem',
        '4': '1rem',
        '8': '2rem',
        '10': '2.5rem',
      },
      colors: {
        'gray': {
          700: '#374151',
          800: '#1F2937',
          900: '#111827',
        },
      },
      scale: {
        '102': '1.02',
      },
    },
  },
  plugins: [],
} 