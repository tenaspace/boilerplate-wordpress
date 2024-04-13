const CustomBlockTest = () => {
  window.Alpine.data('customBlockTest', (text) => ({
    handleClick() {
      console.log(text)
    },
  }))
}

export default CustomBlockTest
