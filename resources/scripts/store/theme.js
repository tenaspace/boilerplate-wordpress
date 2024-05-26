import persist from '@alpinejs/persist'

const Theme = () => {
  window.Alpine.plugin(persist)
  window.Alpine.store('theme', {
    currentTheme: window.Alpine.$persist('system').as('theme'),
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

export default Theme
