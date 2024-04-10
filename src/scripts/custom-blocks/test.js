const CustomBlockTest = () => {
  window.Alpine.data('customBlockTest', (text) => ({
    onClick() {
      console.log(text)
    },
  }))
}

export default CustomBlockTest
