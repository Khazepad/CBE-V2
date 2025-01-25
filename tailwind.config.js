/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      // You can add custom colors if you want to match exactly with AdminLTE
      colors: {
        yellow: {
          400: '#fbbf24', // You can adjust this to match AdminLTE's yellow
          500: '#f59e0b',
          600: '#d97706',
        },
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'), // Optional but recommended for better form styling
  ],
}