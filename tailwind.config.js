/** @type {import('tailwindcss').Config} */
export default {
  content: ["./resources/**/*.blade.php", "./resources/**/*.js"],
  theme: {
    extend: {
      fontFamily: {
        "cune-main": ["Gotham Black", "sans-serif"],
        "cune-sub": ["Gotham Bold", "sans-serif"],
        "cune-text": ["Gotham Book", "sans-serif"],
      },
      colors: {
        "cune-blue": "#192C53",
        "cune-sky": "#5A9DBF",
        "cune-slate": "#646464",
        "cune-nimbus": "#C8C8C8",
        "cune-wheat": "#E2C172",
        "cune-white": "#F7F4ED",
        "cune-clay": "#B2402A",
      },
    },
  },
  plugins: [require("@tailwindcss/forms")],
};
