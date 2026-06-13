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
                sans: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
                serif: ['"Cormorant Garamond"', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                ios: {
                    blue:           '#F07B7B',
                    'blue-dark':    '#D45C5C',
                    'blue-light':   '#FDEAEA',
                    'blue-muted':   '#F5A5A5',
                    bg:             '#FAF6F6',
                    'bg-secondary': '#FFFFFF',
                    label:          '#2A1F1F',
                    'label-secondary': '#716666',
                    separator:      '#E8E0E0',
                    green:          '#4CAF7D',
                    red:            '#CC3333',
                    orange:         '#D97B3A',
                    yellow:         '#D4A017',
                    teal:           '#4FAAAA',
                    indigo:         '#7B75CC',
                    purple:         '#AA6FCC',
                },
            },
            borderRadius: {
                'ios':    '8px',
                'ios-lg': '12px',
                'ios-xl': '18px',
            },
            boxShadow: {
                'ios':    '0 1px 4px rgba(0,0,0,0.05), 0 2px 8px rgba(0,0,0,0.04)',
                'ios-md': '0 2px 10px rgba(0,0,0,0.07), 0 6px 20px rgba(0,0,0,0.05)',
                'ios-lg': '0 4px 20px rgba(0,0,0,0.09), 0 10px 36px rgba(0,0,0,0.07)',
            },
        },
    },
    plugins: [forms],
};
