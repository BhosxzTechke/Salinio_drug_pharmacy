const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
       "./src/**/*.{js,ts,jsx,tsx,vue}", // adjust depending on your project
        "./node_modules/daisyui/dist/**/*.js"

    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        require('daisyui'),
        require('@tailwindcss/forms'),
    ],

    daisyui: {
        themes: ["light", "dark", "corporate"], // optional
    },
};
