import Iodine from '@caneara/iodine'
import { translate } from '../../i18n/translate'
const iodine = new Iodine()

const SampleForm = () => {
  window.Alpine.data('sampleForm', (el) => ({
    fields: {
      fullName: '',
      email: '',
      telephone: '',
      message: '',
      action: '',
      nonce: '',
    },
    errors: {},
    hasFirstSubmit: false,
    isSubmitting: false,
    validate() {
      this.errors = {}
      let result
      if (this.hasFirstSubmit) {
        result = iodine.assert(
          this.fields,
          {
            fullName: ['required'],
            email: ['required', 'email'],
            telephone: ['required'],
            message: [],
            action: ['required'],
            nonce: ['required'],
          },
          {
            fullName: {
              required: translate({
                en: 'This field is required.',
                vi: 'Trường này là bắt buộc.',
              }),
            },
            email: {
              required: translate({
                en: 'This field is required.',
                vi: 'Trường này là bắt buộc.',
              }),
              email: translate({
                en: 'Please enter a valid Email.',
                vi: 'Vui lòng nhập Email hợp lệ.',
              }),
            },
            telephone: {
              required: translate({
                en: 'This field is required.',
                vi: 'Trường này là bắt buộc.',
              }),
            },
            message: {},
            action: {
              required: '',
            },
            nonce: {
              required: '',
            },
          },
        )
        if (!result.valid) {
          Object.keys(result.fields).forEach((field) => {
            if (!result.fields[field].valid) {
              this.errors[field] = result.fields[field].error
            }
          })
        }
      }
      return result
    },
    onSubmit() {
      this.isSubmitting = true
      if (!this.hasFirstSubmit) {
        this.hasFirstSubmit = true
      }
      const validate = this.validate()
      if (validate.valid) {
        fetch(window.constants.adminAjaxUrl, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: new URLSearchParams(this.fields),
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
            } else {
            }
          })
          .catch((error) => {
            console.error(error)
          })
          .finally(() => {})
      }
      this.isSubmitting = false
    },
  }))
}

export { SampleForm }
