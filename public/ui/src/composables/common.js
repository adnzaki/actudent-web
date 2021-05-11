import { Cookies } from 'quasar'
import { ref } from 'vue'
import { core, admin, teacher } from 'boot/axios'
import { appConfig as conf} from '../../actudent.config'
import { bearerToken } from './validate-token'

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

export {
  Cookies,
  ref,
  core, admin, teacher,
  conf,
  bearerToken,
  school,
  getSchool
}
