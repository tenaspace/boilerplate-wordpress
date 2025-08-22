import LazyLoad from 'vanilla-lazyload';

const VanillaLazyLoad = () => {
  window.lazyLoadInstance = new LazyLoad({
    threshold: 0,
  });
  window.Alpine.nextTick(() => {
    window.lazyLoadInstance.update();
  });
};

export { VanillaLazyLoad };
