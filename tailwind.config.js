const glob = require('glob')

module.exports = {
  darkMode: ['class'],
  content: [
    './inc/**/*.php',
    './components/**/*.php',
    './templates/**/*.php',
    './custom-blocks/**/*.php',
    './woocommerce/**/*.php',
    './resources/**/*.{js,ts,jsx,tsx,mdx}',
  ].concat(glob.sync('./*.php')),
  prefix: '',
  theme: {
    extend: {
      fontFamily: {
        'be-vietnam-pro': ['"Be Vietnam Pro", sans-serif'],
      },
    },
  },
  plugins: [
    require('tailwind-bootstrap-grid')({
      generateContainer: false,
      gridGutterWidth: '0',
    }),
  ],
}
