import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
const colors=require('tailwindcss/colors');

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors:{
                transparent:"transparent",
                current:"currentcolor",
                black:colors.black,
                white:colors.white,
                gray:colors.trueGray,
                'gray-background':"#f7f8fc",
                'dark-gray-background':'#EEEEEE', 
                'blue': '#328af1',
                'blue-hover': '#2879bd',
                'yellow': '#ffc73c',
                'red': '#ec454f',
                'green': '#1aab8b',
                'purple': '#8b60ed',
            },
            spacing: {
                22: '5.5rem',
                44: '11rem',
                70: '17.5rem',
                175: '43.75rem',
                76: '19rem',
                104: '26rem',
            },
            maxWidth: {
                  custom: '68.5rem',
            },
            fontFamily: {
                sans: ['Open Sens', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                card: '4px 4px 15px 0 rgba(36, 37, 38, 0.08)',
                dialog: '3px 4px 15px 0 rgba(36, 37, 38, 0.22)',
            },
            fontSize: {
                xxs: ['0.625rem', { lineHeight: '1rem' }],
            },
        },


    },

    plugins: [require('@tailwindcss/forms')],
    plugins: [require('@tailwindcss/line-clamp')],
    
};
