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
                roboto: ['"Roboto"', "sans-serif"],
                jost: ['"Jost"', "sans-serif"],
                poppins: ['"Poppins"', "sans-serif"],
                volkhov: ['"Volkhov"', "sans-serif"],
                // Add more custom font families as needed
            },
            colors: {
                black: '#191919',
                primary: '#ED1C24',
                'primary-dark': '#CC0000',
                secondary: '#A86A3D',
                gray: {
                    50: '#FAFAFA',
                    100: '#F5F5F5',
                    200: '#E5E5E5',
                    500: '#8A8A8A',
                    800: '#323334',
                    900: '#191919',
                    }
                },
            screens: {
                'xs': '375px'
            },
            keyframes: {
                "full-tl": {
                    "0%": { transform: "translateX(0)" },
                    "100%": { transform: "translateX(-100%)" },
                },
                "full-tr": {
                    "0%": { transform: "translateX(0)" },
                    "100%": { transform: "translateX(100%)" },
                },
            },
            animation: {
                "full-tl": "full-tl 25s linear infinite",
                "full-tr": "full-tr 25s linear infinite",
            },
        },
    },

    plugins: [forms],
};
