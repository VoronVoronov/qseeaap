import { required, minLength, sameAs, helpers } from '@vuelidate/validators'
import i18n from '../i18n'

export const mustBeChecked = helpers.withMessage(
    i18n.global.t('validators.agreement'),
    value => value === true
)

export const Required = helpers.withMessage(
    i18n.global.t('validators.required'),
    required
)

export const mLength = (length) =>
    helpers.withMessage(
        i18n.global.t('validators.min', { length }),
        minLength(length)
    )

export const SameAsPassword = (passwordRef) =>
    helpers.withMessage(
        i18n.global.t('validators.sameAs'),
        sameAs(passwordRef)
    )
