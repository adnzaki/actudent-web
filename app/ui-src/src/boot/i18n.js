import { createI18n } from 'vue-i18n'
import messages from 'src/i18n'
import { Cookies } from 'quasar'
import { appConfig as conf } from '../../actudent.config'

const langOptions = {
  english: 'en',
  indonesia: 'id'
}

const i18n = createI18n({
  locale: langOptions[Cookies.get(conf.userLang)],
  messages
})

export default ({ app }) => {
  // Set i18n instance on app
  app.use(i18n)
}

export { i18n }