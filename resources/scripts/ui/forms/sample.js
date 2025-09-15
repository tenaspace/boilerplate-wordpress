import Iodine from '@caneara/iodine';
import { translate } from '../../i18n/translate';
const iodine = new Iodine();

const SampleForm = () => {
  window.Alpine.data('sampleForm', (el) => ({
    fields: {
      fullName: '',
      email: '',
      telephone: '',
      message: '',
    },
    action: '',
    nonce: '',
    token: '',
    hasFirstSubmit: false,
    processing: false,
    allowSubmit: false,
    iodine: {},
    response: undefined,
    init() {
      window.onload = () => {
        window.turnstile.render(this.$refs.turnstileWidget, {
          sitekey: import.meta.env.VITE_CLOUDFLARE_TURNSTILE_SITE_KEY || '',
          theme:
            window.Alpine.store('theme').currentTheme === 'system'
              ? 'auto'
              : window.Alpine.store('theme').currentTheme,
          language: window.constants.currentLanguage,
          callback: (token) => {
            if (token) {
              this.token = token;
              this.allowSubmit = true;
            }
          },
        });
      };
    },
    validate() {
      if (this.hasFirstSubmit) {
        this.iodine = iodine.assert(
          this.fields,
          {
            fullName: ['required'],
            email: ['required', 'email'],
            telephone: ['required'],
            message: [],
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
          },
        );
      } else {
        this.iodine = {};
      }
    },
    reset() {
      this.fields = {
        fullName: '',
        email: '',
        telephone: '',
        message: '',
      };
      el.reset();
      window.turnstile.reset();
    },
    onSubmit() {
      if (this.allowSubmit) {
        this.response = undefined;
        this.processing = true;
        if (!this.hasFirstSubmit) {
          this.hasFirstSubmit = true;
        }
        this.validate();
        if (this.iodine.valid) {
          fetch(window.constants.adminAjaxUrl, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
              ...this.fields,
              action: this.action,
              nonce: this.nonce,
              token: this.token,
            }),
          })
            .then((response) => response.json())
            .then((data) => {
              if (data.response) {
                this.reset();
              }
              this.response = data.response;
              this.processing = false;
            })
            .catch((error) => {
              console.error(error);
              this.response = false;
              this.processing = false;
            })
            .finally(() => {});
        }
      }
    },
  }));
};

export { SampleForm };
