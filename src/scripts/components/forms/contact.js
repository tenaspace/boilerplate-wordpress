import Iodine from '@caneara/iodine'
import { load } from 'recaptcha-v3'

const iodine = new Iodine()

const FormContact = () => {
  window.Alpine.data(`formContact`, (el) => ({
    fields: {
      action: el.getAttribute(`data-action`),
      nonce: el.getAttribute(`data-nonce`),
      fullName: ``,
      email: ``,
      phoneNumber: ``,
      message: ``,
    },
    rules: {
      action: [`required`],
      nonce: [`required`],
      fullName: [`required`],
      email: [`required`, `email`],
      phoneNumber: [`required`, `minLength:10`, `maxLength:10`],
    },
    errors: {
      fullName: {
        required: `Full name is required.`,
      },
      email: {
        required: `E-mail is required.`,
        email: `E-mail is not valid.`,
      },
      phoneNumber: {
        required: `Phone number is required.`,
        'minLength:10': `Phone number is not valid.`,
        'maxLength:10': `Phone number is not valid.`,
      },
    },
    firstSubmited: false,
    loading: false,
    states: {},
    onValidate() {
      this.states = this.firstSubmited && iodine.assert(this.fields, this.rules, this.errors)
    },
    onSubmit() {
      if (!this.firstSubmited) {
        this.firstSubmited = true
      }
      this.loading = true
      this.onValidate()
      console.log(this.states)
      if (this.states.valid) {
        load(import.meta.env.VITE_GOOLE_RECAPTCHA_SITE_KEY ?? ``)
          .then((recaptcha) => {
            recaptcha
              .execute(this.fields.action)
              .then((token) => {
                fetch(window.app.adminAjaxUrl, {
                  method: `POST`,
                  headers: {
                    'Content-type': `application/x-www-form-urlencoded`,
                  },
                  cache: `no-cache`,
                  body: new URLSearchParams({ ...this.fields, token }),
                })
                  .then((response) => response.json())
                  .then((response) => {
                    if (response.success) {
                      el.reset()
                    } else {
                    }
                    this.loading = false
                  })
                  .catch(() => {
                    this.loading = false
                  })
              })
              .catch(() => {
                console.log('2')
                this.loading = false
              })
          })
          .catch(() => {
            console.log('1')
            this.loading = false
          })
      } else {
        this.loading = false
      }
    },
  }))
}

export default FormContact
