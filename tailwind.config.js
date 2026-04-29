import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                serif: ['"Playfair Display"', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                cream: {
                    50: '#FDFAF5',
                    100: '#FAF3E7',
                    200: '#F4E8D4',
                    300: '#EBD9BA',
                },
                terracotta: {
                    50: '#FBF1EC',
                    100: '#F5DCCD',
                    200: '#EAB59C',
                    300: '#DC8C68',
                    400: '#C96A41',
                    500: '#B5532E',
                    600: '#9A4123',
                    700: '#7C341D',
                },
                clay: {
                    50: '#F8F4F0',
                    100: '#EDE3D8',
                    200: '#D6BFA9',
                    300: '#B89679',
                    400: '#8E6A4D',
                    500: '#6B4F39',
                },
            },
            boxShadow: {
                'warm': '0 4px 14px 0 rgba(181, 83, 46, 0.08)',
                'warm-lg': '0 10px 30px -5px rgba(181, 83, 46, 0.15)',
            },
        },
    },

    plugins: [forms],
};
