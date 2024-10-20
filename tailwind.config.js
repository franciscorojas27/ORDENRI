import defaultTheme from 'tailwindcss/defaultTheme';
import animations from '@midudev/tailwind-animations'
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            transitionProperty: {
                'height': 'height',
                'spacing': 'margin, padding',
              }
        },
    },

    plugins: [forms,animations],
};
