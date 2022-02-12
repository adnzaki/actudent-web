import { Cookies, conf } from './common'
import id from 'quasar/lang/id'
import en from 'quasar/lang/en-US'

const langOptions = {
  indonesia: id.date,
  english: en.date
}

const selectedLang = langOptions[Cookies.get(conf.userLang)]

const date = new Date()
const month = date.getMonth() + 1
const todayStr = [
  date.getFullYear(),
  month < 10 ? `0${month}` : month,
  date.getDate() < 10 ? `0${date.getDate()}` : date.getDate()
].join('/') // resulting today's date string in YYYY/MM/DD format like '2022/02/12'

export { selectedLang, todayStr }