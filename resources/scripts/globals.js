import Alpine from 'alpinejs';
import { Components } from './components';
import { CustomBlocks } from './custom-blocks';
import { Libraries } from './libraries';
import { Store } from './store';
import { Ui } from './ui';

/**
 * Alpinejs Safari fix: https://github.com/alpinejs/alpine/discussions/1964
 */

window.queueMicrotask = (callback) => {
  Promise.resolve()
    .then(callback)
    .catch((e) =>
      setTimeout(() => {
        throw e;
      }),
    );
};

window.Alpine = Alpine;

/* Add any custom values between this line and the "stop editing" line. */

Store();
Libraries();
Components();
Ui();
CustomBlocks();

/* That's all, stop editing! Happy publishing. */

window.Alpine.start();
