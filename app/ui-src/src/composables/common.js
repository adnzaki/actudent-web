import { Cookies } from 'quasar'
import { ref } from 'vue'
import { axios, core, admin, teacher } from 'boot/axios'
import { i18n } from 'boot/i18n'
import { appConfig as conf} from '../../actudent.config'
import { bearerToken, validateToken, redirect } from './validate-token'
import { runLoadingBar } from './loading-bar'
import { flashAlert, errorNotif, timeout } from './notify'
import { pengguna, getPengguna } from './get-pengguna'

const t = key => i18n.global.t(key)

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
  t
}
