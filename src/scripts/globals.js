// import jQuery from "jquery";
// window.$ = window.jQuery = jQuery;
import LazyLoad from 'vanilla-lazyload'
import FormContact from './components/forms/contact'

/**
 * LazyLoad
 */

document.addEventListener(`alpine:init`, () => {
  window.lazyLoadInstance = new LazyLoad({
    threshold: 0,
  })
  window.Alpine.nextTick(() => {
    window.lazyLoadInstance.update()
  })
})

/**
 * Components
 */

FormContact()
