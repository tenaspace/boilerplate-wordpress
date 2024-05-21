const Providers = () => {
  window.Alpine.data('providers', () => ({
    windowSize: {
      width: '0px',
      height: '0px',
      set() {
        this.width = `${window.innerWidth || document.documentElement.clientWidth}px`
        this.height = `${window.innerHeight || document.documentElement.clientHeight}px`
      },
      init() {
        this.set()
      },
    },
    init() {
      this.windowSize.init()
    },
  }))
}

export default Providers
