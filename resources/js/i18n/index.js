import { createI18n } from 'vue-i18n'
import ru from './ru.json'
import kz from './kz.json'
import en from './en.json'
const i18n = createI18n({
    locale: 'ru',
    fallbackLocale: 'ru',
    messages: {
        ru,
        kz,
        en
    }
})

export default i18n
