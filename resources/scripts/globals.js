import Alpine from 'alpinejs'
import { Store } from './store'
import { Libraries } from './libraries'
import { Components } from './components'
import { DynamicBlocks } from './dynamic-blocks'

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

window.Alpine = Alpine

/* Add any custom values between this line and the "stop editing" line. */

Store()
Libraries()
Components()
DynamicBlocks()

/* That's all, stop editing! Happy publishing. */

window.Alpine.start()
