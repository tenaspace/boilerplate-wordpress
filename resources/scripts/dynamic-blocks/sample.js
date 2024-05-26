const Sample = () => {
  window.Alpine.data('dynamicBlockSample', (el) => ({
    handleClick() {
      console.log(el)
    },
  }))
}

export default Sample
