const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {

    applyComplexClasses: true,
    purge: {
        enabled: true, // to remove unused styles by scanning them on the following files
        content: [
            './resources/views/**/*.php',
            './resources/assets/js/**/*.vue',
            './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
            './vendor/laravel/jetstream/**/*.blade.php',
            './storage/framework/views/*.php'
        ]
    },
    sourceMap: false,
    theme: {
        extend: {
            colors: {
                stella: {
                    DEFAULT: '#277975',
                },
                roast: {
                    dark: '#1E1618',
                    light: '#331813',
                    lightest: '#773714',
                },
            },
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
                mono: ["robot", ...defaultTheme.fontFamily.mono],
            },
            fontSize: {
                '4xl': '42px',
            }
        },
    },

    variants: {
        extend: {
            scale: ['active', 'group-hover'],
            opacity:
                ['disabled'],
            backgroundColor:
                ['active'],
            textColor:
                ['active', 'focus', 'hover'],
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography')
    ],
};
