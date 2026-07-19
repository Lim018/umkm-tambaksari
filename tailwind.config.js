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
            },
            colors: {
                navy: '#1B2559',
                'grey-soft': '#8F9BBA',
                primary: '#3B6FF5',
                ungu: '#8B5CF6',
                coral: '#FF6B4A',
                kuning: '#FFB800',
                teal: '#2DD4BF',
                pastel: {
                    pink: '#FCE7F3',
                    ungu: '#EDE9FE',
                    biru: '#DBEAFE',
                    mint: '#D1FAE5',
                },
            },
            borderRadius: {
                pill: '999px',
            },
            boxShadow: {
                soft: '0 18px 50px -22px rgba(27,37,89,.28)',
                card: '0 20px 46px -26px rgba(27,37,89,.35)',
                'card-hover': '0 34px 60px -28px rgba(139,92,246,.5)',
                'cat-hover': '0 26px 48px -22px rgba(59,111,245,.5)',
                search: '0 26px 60px -22px rgba(27,37,89,.32)',
            },
            keyframes: {
                floaty: {
                    '0%,100%': { transform: 'translateY(0) rotate(0deg)' },
                    '50%': { transform: 'translateY(-26px) rotate(8deg)' },
                },
                floaty2: {
                    '0%,100%': { transform: 'translateY(0) rotate(0deg)' },
                    '50%': { transform: 'translateY(22px) rotate(-10deg)' },
                },
            },
            animation: {
                floaty: 'floaty 9s ease-in-out infinite',
                floaty2: 'floaty2 7s ease-in-out infinite',
            },
        },
    },

    plugins: [forms],
};
