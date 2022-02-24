import { createI18n } from 'vue-i18n'
import messages from 'src/i18n'

const langOptions = {
  english: 'en',
  indonesia: 'id'
}

const userLang = localStorage.getItem('ac_userlang')
const selectedLang = userLang !== null ? userLang : 'indonesia'

const i18n = createI18n({
  locale: langOptions[selectedLang],
  messages
})

export default ({ app }) => {
  // Set i18n instance on app
  app.use(i18n)
}

export { i18n }