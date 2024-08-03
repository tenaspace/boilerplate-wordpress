const glob = require('glob')
import { fontFamily } from 'tailwindcss/defaultTheme'

module.exports = {
  darkMode: ['class'],
  content: [
    './inc/**/*.php',
    './components/**/*.php',
    './templates/**/*.php',
    './blocks/**/*.php',
    './woocommerce/**/*.php',
    './resources/**/*.{js,ts,jsx,tsx,mdx}',
  ].concat(glob.sync('./*.php')),
  prefix: '',
  theme: {
    extend: {
      fontFamily: {
        sans: ['"Be Vietnam Pro", sans-serif', ...fontFamily.sans],
      },
    },
  },
  plugins: [
    require('tailwindcss-animate'),
    require('tailwind-bootstrap-grid')({
      generateContainer: false,
      gridGutterWidth: '0',
    }),
  ],
}
