/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./*.php", "./**/*.php"],
  theme: {
    extend: {},
    container: {
      center: true,
      padding: {
        DEFAULT: "1rem", // Default padding for all screens
        sm: "2rem", // Padding for small screens
        lg: "4rem", // Padding for large screens
        xl: "5rem", // Padding for extra-large screens
        "2xl": "6rem", // Padding for 2xl screens
      },
      screens: {
        sm: "600px",
        md: "720px",
        lg: "960px",
        xl: "1140px",
        "2xl": "1320px",
      },
    },
  },
  plugins: [],
};
