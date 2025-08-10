const Theme = () => {
  const defaultTheme = 'system'
  window.Alpine.store('theme', {
    defaultTheme: defaultTheme,
    currentTheme: window.localStorage.getItem('theme') || defaultTheme,
    handleTheme() {
      const isDark =
        this.currentTheme === 'system'
          ? (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light') === 'dark'
          : this.currentTheme === 'dark'
      if (isDark) {
        document.documentElement.style.colorScheme = 'dark'
        document.documentElement.classList.remove('light')
        document.documentElement.classList.add('dark')
      } else {
        document.documentElement.style.colorScheme = 'light'
        document.documentElement.classList.remove('dark')
        document.documentElement.classList.add('light')
      }
    },
    setTheme(theme) {
      window.localStorage.setItem('theme', theme)
      this.currentTheme = theme
      this.handleTheme()
    },
    init() {
      this.handleTheme()
      window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
        this.handleTheme()
      })
    },
  })
}

export { Theme }
