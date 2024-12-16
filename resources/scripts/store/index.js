import { Theme } from './theme'
import { WindowSize } from './window-size'

const Store = () => {
  window.Alpine.store('globals', {
    openSidenav: false,
    handleOpenSidenav(openSidenav) {
      this.openSidenav = openSidenav
    },
  })
  Theme()
  WindowSize()
}

export { Store }
