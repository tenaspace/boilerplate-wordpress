module.exports = {
  content: [
    './*.php',
    './inc/**/*.php',
    './ui/**/*.php',
    './woocommerce/**/*.php',
    './src/**/*.{php,js,ts,jsx,tsx,mdx}',
  ],
  theme: {
    extend: {
      zIndex: {
        dropdown: 1000,
        sticky: 1020,
        fixed: 1030,
        'offcanvas-backdrop': 1040,
        offcanvas: 1045,
        'modal-backdrop': 1050,
        modal: 1055,
        popover: 1070,
        tooltip: 1080,
        toast: 1090,
      },
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
