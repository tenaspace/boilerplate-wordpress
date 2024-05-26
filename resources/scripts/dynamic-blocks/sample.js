const Sample = () => {
  window.Alpine.data('dynamicBlockSample', (el) => ({
    handleClick() {
      console.log(el.innerText)
    },
  }))
}

export default Sample
