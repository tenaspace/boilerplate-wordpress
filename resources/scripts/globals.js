import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse'
import focus from '@alpinejs/focus'
import mask from '@alpinejs/mask'
import VanillaLazyLoad from './libraries/vanilla-lazyload'
// import FormSample from './components/forms/sample'
import CustomBlockSample from './custom-blocks/sample'
import Providers from './providers'

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

Providers();

/**
 * Libraries
 */

VanillaLazyLoad()

/**
 * Components
 */

// FormSample();

/**
 * Custom blocks
 */

CustomBlockSample()

/* That's all, stop editing! Happy publishing. */

Alpine.start()
