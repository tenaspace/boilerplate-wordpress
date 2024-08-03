const SampleBlock = () => {
  window.Alpine.data('sampleBlock', (el) => ({
    handleClick() {
      console.log(el.innerText)
    },
  }))
}

export { SampleBlock }
