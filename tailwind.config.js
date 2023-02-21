/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    fontFamily: {
      'sans': [ 'DM Sans', 'sans-serif' ],
      'serif': [ 'DM Serif Display', 'serif' ]
    },
    extend: {
      backgroundImage: {
        'home-background': "url('../static/img/home.jpg')"
      }
    },
  },
  plugins: [],
}
