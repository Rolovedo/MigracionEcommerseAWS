/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./src/Resources/**/*.blade.php", "./src/Resources/**/*.js"],

    theme: {
        container: {
            center: true,

            screens: {
                "2xl": "1440px",
            },

            padding: {
                DEFAULT: "90px",
            },
        },

        screens: {
            sm: "525px",
            md: "768px",
            lg: "1024px",
            xl: "1240px",
            "2xl": "1440px",
            1180: "1180px",
            1060: "1060px",
            991: "991px",
            868: "868px",
        },

        extend: {
            colors: {
                navyBlue: "#060C3B",
                lightOrange: "#f8f4ec",
                darkGreen: '#40994A',
                darkBlue: '#0044F2',
                darkPink: '#F85156',
                lightBrown: '#eee1d2',
                brown: {
                    DEFAULT: "#8B5E3C",
                    50:  "#F4E8E0",
                    100: "#E8D3C2",
                    200: "#D9B89E",
                    300: "#C99D7B",
                    400: "#B8825B",
                    500: "#8B5E3C",
                    600: "#734A2E",
                    700: "#5B3722",
                    800: "#432517",
                    900: "#2C150E",
                    950: "#180A06"
                  }
                //white: '#ff0000',
            },

            fontFamily: {
                poppins: ["Poppins"],
                dmserif: ["DM Serif Display"],
            },
        }
    },

    plugins: [],

    safelist: [
        {
            pattern: /icon-/,
        }
    ]
};
