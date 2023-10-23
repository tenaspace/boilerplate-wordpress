import Alpine from "alpinejs";
import collapse from "@alpinejs/collapse";
import focus from "@alpinejs/focus";
import mask from "@alpinejs/mask";
import LazyLoad from "vanilla-lazyload";
// import jQuery from "jquery";
// window.$ = window.jQuery = jQuery;

/**
 * Alpinejs register
 */

window.Alpine = Alpine;

/**
 * Alpinejs plugins
 */

window.Alpine.plugin(collapse);
window.Alpine.plugin(focus);
window.Alpine.plugin(mask);

/**
 * Alpinejs Safari fix: https://github.com/alpinejs/alpine/discussions/1964
 */

if (typeof window.queueMicrotask !== `function`) {
  window.queueMicrotask = (callback) => {
    Promise.resolve()
      .then(callback)
      .catch((e) =>
        setTimeout(() => {
          throw e;
        })
      );
  };
}

/**
 * LazyLoad
 */

window.lazyLoadInstance = new LazyLoad({
  threshold: 0,
});

window.Alpine.nextTick(() => {
  window.lazyLoadInstance.update();
});
