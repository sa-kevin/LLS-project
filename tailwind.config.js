import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.jsx',
  ],

  theme: {
    extend: {
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
        title: ['Orbitron'],
        main: ['Noto Sans JP'],
        klee: ['Klee One'],
      },
      keyframes: {
        wave: {
          '0%': { transform: 'translateX(0%)' },
          '50%': { transform: 'translateX(-25%)' },
          '100%': { transform: 'translateX(-50%)' },
        },
      },
      animation: {
        wave: 'wave 15s linear infinite',
      },
    },
  },

  plugins: [forms],
};
