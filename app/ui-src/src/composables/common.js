import { Cookies } from 'quasar'
import { ref } from 'vue'
import { axios, core, admin, teacher } from 'boot/axios'
import { i18n } from 'boot/i18n'
import { appConfig as conf} from '../../actudent.config'
import { bearerToken, validateToken, redirect } from './validate-token'
import { runLoadingBar } from './loading-bar'
import { flashAlert, errorNotif, timeout } from './notify'
import { pengguna, getPengguna } from './get-pengguna'

const trim = (text, length = 25) => {
  const returnedText = text.length <= length 
                     ? text
                     : text.substring(0, length) + '...'
  
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

  for(let item in obj) {
    formData.append(item, obj[item])
  }

  return formData
}

export {
  formatDate,
  trim,
  apiEndpoint,
  Cookies,
  ref,
  axios, core, admin, teacher,
  conf,
  bearerToken,
  validateToken,
  redirect,
  school,
  getSchool,
  runLoadingBar,
  flashAlert,
  errorNotif,
  timeout,
  createFormData,
  pengguna, getPengguna,
  t,
  createQueryString
}
