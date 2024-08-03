const WindowSize = () => {
  window.Alpine.store('windowSize', {
    width: '0px',
    height: '0px',
    handleWindowSize() {
      this.width = `${window.innerWidth || document.documentElement.clientWidth}px`
      this.height = `${window.innerHeight || document.documentElement.clientHeight}px`
    },
    init() {
      this.handleWindowSize()
      window.addEventListener('resize', () => {
        this.handleWindowSize()
      })
    },
  })
}

export { WindowSize }
