import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse'
import focus from '@alpinejs/focus'
import mask from '@alpinejs/mask'

/**
 * Alpinejs Safari fix: https://github.com/alpinejs/alpine/discussions/1964
 */

if (typeof window.queueMicrotask !== `function`) {
  window.queueMicrotask = (callback) => {
    Promise.resolve()
      .then(callback)
      .catch((e) =>
        setTimeout(() => {
          throw e
        }),
      )
  }
}

Alpine.plugin(collapse)
Alpine.plugin(focus)
Alpine.plugin(mask)

window.Alpine = Alpine

Alpine.start()
