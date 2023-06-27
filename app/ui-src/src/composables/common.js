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
import { pengguna, getPengguna } from './get-pengguna'

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
  Cookies,
  ref,
  axios, core, admin, teacher,
  conf,
  bearerToken,
  validateToken,
  runLoadingBar,
  createFormData,
  isAuthenticated,
  createQueryString,
  pengguna, getPengguna,
  axios, core, admin, teacher,
}
