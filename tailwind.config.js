/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    darkMode: 'class',

    purge: [
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                discordBlue: '#7289DA',
                discordGrey: '#99AAB5',
                discordDark: '#2C2F33',
                discordBlack: '#23272A',
                divGrey: '#394248',
                aGrey: '#58585f',
                bodyBG: '#36393f',
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
            visibility: ['hover'],
            zIndex: ['hover'],
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
