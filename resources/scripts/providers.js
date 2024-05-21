const Providers = () => {
  window.Alpine.data('providers', () => ({
    windowSize: {
      width: '0px',
      height: '0px',
    },
    useWindowSize() {
      this.windowSize.width = `${window.innerWidth || document.documentElement.clientWidth}px`
      this.windowSize.height = `${window.innerHeight || document.documentElement.clientHeight}px`
    },
    init() {
      this.useWindowSize()
    },
  }))
}

export default Providers
