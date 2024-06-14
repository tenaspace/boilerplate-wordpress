const WindowSize = () => {
  window.Alpine.store('windowSize', {
    width: '0px',
    height: '0px',
    init() {
      const resizeObserver = new ResizeObserver(() => {
        this.width = `${window.innerWidth || document.documentElement.clientWidth}px`;
        this.height = `${window.innerHeight || document.documentElement.clientHeight}px`;
      });
      resizeObserver.observe(document.documentElement);
    },
  });
};

export default WindowSize;
