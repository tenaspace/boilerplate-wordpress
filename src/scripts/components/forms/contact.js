import Iodine from '@caneara/iodine'
import { load } from 'recaptcha-v3'

const iodine = new Iodine()

const FormContact = () => {
  const dict = window.app?.dictionaries?.components?.forms?.contact
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
        required: dict?.inputs?.fullName?.message?.required,
      },
      email: {
        required: dict?.inputs?.email?.message?.required,
        email: dict?.inputs?.email?.message?.pattern,
      },
      phoneNumber: {
        required: dict?.inputs?.phoneNumber?.message?.required,
        'minLength:10': dict?.inputs?.phoneNumber?.message?.min,
        'maxLength:10': dict?.inputs?.phoneNumber?.message?.max,
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
      if (this.states.valid) {
        load(import.meta.env.VITE_GOOLE_RECAPTCHA_SITE_KEY ?? ``)
          .then((recaptcha) => {
            recaptcha
              .execute(this.fields.action)
              .then((token) => {
                fetch(window.app?.adminAjaxUrl, {
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
                      alert(dict.responses.success)
                    } else {
                      alert(dict.responses.error)
                    }
                    this.loading = false
                  })
                  .catch(() => {
                    alert(dict.responses.error)
                    this.loading = false
                  })
              })
              .catch(() => {
                alert(dict.responses.error)
                this.loading = false
              })
          })
          .catch(() => {
            alert(dict.responses.error)
            this.loading = false
          })
      } else {
        this.loading = false
      }
    },
  }))
}

export default FormContact
