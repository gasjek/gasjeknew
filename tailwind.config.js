/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
      "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    screens: {
      sm: "640px",
      md: "768px",
      lg: "1024px",
      xl: "1280px",
    },
    container: {
      padding: "25px",
      center: true,
    },
    colors: {
      primary: {
        DEFAULT: "#305aa9",
        hover: "#2A55A5",
      },
      secondary: {
        DEFAULT: "#093a8d",
        hover: "#053382",
      },
    },
    fontFamily: {
      primary: ["Days One", "sans-serif"],
      secondary: ["Rambla", "sans-serif"],
    },
    backgroundImage: {
      'hero': "url('public/storage/img/bg.jpg')",
    },
    extend: {
      spacing: {
        '128': '32rem',
        '144': '36rem',
      },
      borderRadius: {
        '4xl': '2rem',
      }
    }
  },
  plugins: [
    require('flowbite/plugin'),
    require('flowbite-typography'),
  ],
}

