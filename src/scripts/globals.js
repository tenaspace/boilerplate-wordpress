import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse'
import focus from '@alpinejs/focus'
import mask from '@alpinejs/mask'
// import jQuery from "jquery";
// window.$ = window.jQuery = jQuery;
import VanillaLazyLoad from './vanilla-lazyload'
import FormContact from './components/forms/contact'

/**
 * Alpinejs Safari fix: https://github.com/alpinejs/alpine/discussions/1964
 */

window.queueMicrotask = (callback) => {
  Promise.resolve()
    .then(callback)
    .catch((e) =>
      setTimeout(() => {
        throw e
      }),
    )
}

Alpine.plugin(collapse)
Alpine.plugin(focus)
Alpine.plugin(mask)

window.Alpine = Alpine

/* Add any custom values between this line and the "stop editing" line. */

window.Alpine.data('app', () => ({
  windowSize: {
    width: '0px',
    height: '0px',
  },
  useWindowSize() {
    this.windowSize.width = `${window.innerWidth}px`
    this.windowSize.height = `${window.innerHeight}px`
  },
  init() {
    this.useWindowSize()
  },
}))

/**
 * libs
 */

VanillaLazyLoad()

/**
 * components
 */

FormContact()

/* That's all, stop editing! Happy publishing. */

Alpine.start()
