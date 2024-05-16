const CustomBlockSample = () => {
  window.Alpine.data('customBlockSample', (el) => ({
    handleClick() {
      console.log(el)
    },
  }))
}

export default CustomBlockSample
