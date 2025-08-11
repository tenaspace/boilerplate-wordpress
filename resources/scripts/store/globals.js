const Globals = () => {
  window.Alpine.store('globals', {
    openSidenav: false,
    handleOpenSidenav(openSidenav) {
      this.openSidenav = openSidenav
    },
  })
}

export { Globals }
