/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./views/**/*.{php,js}'],
  theme: {
    extend: {},
  },
  plugins: [
    function ({ addVariant }) {
        addVariant('child', '& > *');
        addVariant('child-hover', '& > *:hover');
    }
  ],
}

