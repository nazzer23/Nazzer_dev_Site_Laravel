const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                'sans': ['"Open Sans"', ...defaultTheme.fontFamily.sans],
                'secondary': ['"SpaceGrotesk"', ...defaultTheme.fontFamily.mono]
            },
            screens: {
                laptop: {max: "1280px"},
                // => @media (max-width: 1280px) { ... }

                tablet: {max: "1024px"},
                // => @media (max-width: 1024px) { ... }

                mobile: {max: "767px"},
                // => @media (max-width: 767px) { ... }
            },
            colors: {
                "primary": {
                    DEFAULT: '#5376C0',
                    50: '#C9D4EB',
                    100: '#BCC9E6',
                    200: '#A2B4DD',
                    300: '#889FD3',
                    400: '#6D8BCA',
                    500: '#5376C0',
                    600: '#3B5BA0',
                    700: '#2C4477',
                    800: '#1D2C4E',
                    900: '#0E1525',
                    950: '#060A11'
                },
                "secondary": {
                    DEFAULT: '#562A89',
                    50: '#FBF7FC',
                    100: '#F6ECF9',
                    200: '#E2C4ED',
                    300: '#CB9DE1',
                    400: '#B276D5',
                    500: '#954FC9',
                    600: '#7536B0',
                    700: '#562A89',
                    800: '#34224F',
                    900: '#1E172B',
                    950: '#171320'
                }
            }
        },
    },
    plugins: [
        require("@designbycode/tailwindcss-text-stroke"),
        require('flowbite/plugin')
    ],
    darkMode: 'class',
}

