/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./views/**/*.php'],
  theme: {
    extend: {
      fontFamily: {
        roboto: ['Roboto']
      }
    },
  },
  plugins: [
    function ({ addVariant }) {
        addVariant('child', '& > *');
        addVariant('child-hover', '& > *:hover');
    }
  ],
}

