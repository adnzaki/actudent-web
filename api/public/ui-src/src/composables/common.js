import { Cookies } from 'quasar'
import { ref } from 'vue'
import { core, admin, teacher } from 'boot/axios'
import { appConfig as conf} from '../../actudent.config'
import { bearerToken, validateToken, redirect } from './validate-token'
import { runLoadingBar } from './loading-bar'
import { flashAlert, errorNotif } from './notify'

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
  core, admin, teacher,
  conf,
  bearerToken,
  validateToken,
  redirect,
  school,
  getSchool,
  runLoadingBar,
  flashAlert,
  errorNotif,
  createFormData
}
