import Iodine from '@caneara/iodine'
import { load } from 'recaptcha-v3'

const iodine = new Iodine()

const FormContact = () => {
  document.addEventListener(`alpine:init`, () => {
    window.Alpine.data(`formContact`, (el) => ({
      actionUrl: el.getAttribute(`data-action-url`),
      fields: {
        action: el.getAttribute(`data-action`),
        referer: el.getAttribute(`data-referer`),
        nonce: el.getAttribute(`data-nonce`),
        fullName: ``,
        email: ``,
        telephone: ``,
        message: ``,
      },
      rules: {
        action: [`required`],
        referer: [`required`],
        nonce: [`required`],
        fullName: [`required`],
        email: [`required`, `email`],
        telephone: [`required`, `minLength:10`, `maxLength:10`],
      },
      errors: {
        fullName: {
          required: `Full name is required.`,
        },
        email: {
          required: `E-mail is required.`,
          email: `E-mail is not valid.`,
        },
        telephone: {
          required: `Telephone is required.`,
          'minLength:10': `Telephone is not valid.`,
          'maxLength:10': `Telephone is not valid.`,
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
                  fetch(this.actionUrl, {
                    method: `POST`,
                    headers: {
                      'Content-type': `application/x-www-form-urlencoded`,
                    },
                    body: new URLSearchParams({ ...this.fields, token }),
                  })
                    .then((response) => response.json())
                    .then((response) => {
                      if (response.success) {
                        // console.log(`reset`)
                        // console.log(`success`)
                      } else {
                        if(response.error) {
                          console.error(response.error)
                        }
                        // console.log(`error`)
                      }
                      this.loading = false
                    })
                    .catch((error) => {
                      console.error(error)
                      // console.log(`error`)
                      this.loading = false
                    })
                })
                .catch((error) => {
                  console.error(error)
                  // console.log(`error`)
                  this.loading = false
                })
            })
            .catch((error) => {
              console.error(error)
              // console.log(`error`)
              this.loading = false
            })
        } else {
          this.loading = false
        }
      },
    }))
  })
}

export default FormContact
