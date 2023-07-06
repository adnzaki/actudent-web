import { Cookies, date } from 'quasar'
import { ref, computed } from 'vue'
import { i18n } from 'boot/i18n'
import { runLoadingBar } from './loading-bar'
import { validateToken } from './validate-token'
import { pengguna, getPengguna } from './get-pengguna'
import { bearerToken, redirect } from './subscription'
import { axios, core, admin, teacher, siabsen } from 'boot/axios'
import { appConfig as conf } from '../../actudent.config'
import { flashAlert, errorNotif, timeout } from './notify'
import { selectedLang } from './date'

const userType = Cookies.get(conf.userType)
const isAuthenticated = computed(() => Cookies.get(conf.cookieName) !== null)

const trim = (text, length = 25, ellipsis = true) => {
  const dots = ellipsis ? '...' : ''
  const returnedText = text.length <= length
    ? text
    : text.substring(0, length) + dots

  return returnedText
}

const apiEndpoint = Cookies.get(conf.userType) === '1'
  ? conf.adminAPI : conf.teacherAPI

const t = key => i18n.global.t(key)

const formatDate = (val, format = 'dddd, DD MMMM YYYY') => {
  return date.formatDate(val, format, selectedLang)
}

const createQueryString = params => {
  return Object.entries(params).map(item => item.join('=')).join('&')
}

let school = ref({})

function getSchool() {
  core.get('sekolah', {
    headers: { Authorization: bearerToken }
  })
    .then(response => {
      school.value = response.data
    })
    .catch(error => {
      console.error(`Error: ${error}`)
    })
}

function createFormData(obj) {
  let formData = new FormData()

  for (let item in obj) {
    formData.append(item, obj[item])
  }

  return formData
}

const monthList = () => {
  return [
    { label: t('mon1'), value: '01' },
    { label: t('mon2'), value: '02' },
    { label: t('mon3'), value: '03' },
    { label: t('mon4'), value: '04' },
    { label: t('mon5'), value: '05' },
    { label: t('mon6'), value: '06' },
    { label: t('mon7'), value: '07' },
    { label: t('mon8'), value: '08' },
    { label: t('mon9'), value: '09' },
    { label: t('mon10'), value: '10' },
    { label: t('mon11'), value: '11' },
    { label: t('mon12'), value: '12' },
  ]
}

const toDecimal = time => {
  time = time.split(':')
  let hour = time[0],
    mins = time[1] / 60

  return hour + mins
}

const phpTimestamp = val => Date.parse(val).toString().substring(0, 10)

export {
  t,
  ref,
  trim,
  conf,
  school,
  Cookies,
  timeout,
  redirect,
  userType,
  getSchool,
  formatDate,
  monthList,
  toDecimal,
  phpTimestamp,
  errorNotif,
  flashAlert,
  apiEndpoint,
  bearerToken,
  validateToken,
  runLoadingBar,
  createFormData,
  isAuthenticated,
  createQueryString,
  pengguna, getPengguna,
  axios, core, admin, teacher, siabsen
}
