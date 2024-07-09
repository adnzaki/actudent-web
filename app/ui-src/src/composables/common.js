import { Cookies } from 'quasar'
import { ref, computed } from 'vue'
import { i18n } from 'boot/i18n'
import { runLoadingBar } from './loading-bar'
import { validateToken } from './validate-token'
import { pengguna, getPengguna } from './get-pengguna'
import { bearerToken, redirect } from './subscription'
import { axios, core, admin, teacher, install } from 'boot/axios'
import { appConfig as conf } from '../../actudent.config'
import { flashAlert, errorNotif, timeout } from './notify'
import { actionButton, addButton, fabColor } from 'src/composables/mode'

const userType = Cookies.get(conf.userType)
const isAuthenticated = computed(() => Cookies.get(conf.cookieName) !== null)

let dashboardLink = '/home'

if (userType === '2' || userType === '0') dashboardLink = '/teacher/home'
else if (userType === '3') dashboardLink = '/student/home'

const trim = (text, length = 25, ellipsis = true) => {
  const dots = ellipsis ? '...' : ''
  const returnedText =
    text.length <= length ? text : text.substring(0, length) + dots

  return returnedText
}

const apiEndpoint =
  Cookies.get(conf.userType) === '1' ? conf.adminAPI : conf.teacherAPI

const t = (key) => i18n.global.t(key)

const formatDate = (val, format = 'dddd, DD MMMM YYYY') => {
  return date.formatDate(val, format, selectedLang)
}

const phpTimestamp = (val) => Date.parse(val).toString().substring(0, 10)

const createQueryString = (params) => {
  return Object.entries(params)
    .map((item) => item.join('='))
    .join('&')
}

let school = ref({})

function getSchool() {
  core
    .get('sekolah', {
      headers: { Authorization: bearerToken },
    })
    .then((response) => {
      school.value = response.data
    })
    .catch((error) => {
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

export {
  t,
  ref,
  trim,
  conf,
  school,
  Cookies,
  timeout,
  fabColor,
  redirect,
  userType,
  getSchool,
  formatDate,
  errorNotif,
  flashAlert,
  apiEndpoint,
  bearerToken,
  validateToken,
  runLoadingBar,
  dashboardLink,
  createFormData,
  isAuthenticated,
  createQueryString,
  pengguna,
  getPengguna,
  actionButton,
  phpTimestamp,
  addButton,
  axios,
  core,
  admin,
  teacher,
  install,
}
