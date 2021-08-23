import { ref } from 'vue'
import { core } from 'boot/axios'
import { bearerToken } from 'src/composables/validate-token'
import { Cookies } from 'quasar'
import { appConfig as conf } from '../../actudent.config'

const lang = ref({
  english: [],
  indonesia: []
})

const userLang = Cookies.get(conf.userLang)

const fetchLang = (file, selectedLang = '') => {
  let url 
  selectedLang === '' ? url = file :  url = `${file}/${selectedLang}`
  core.get(`get-lang/${url}`, {
    headers: {
      Authorization: bearerToken
    }
  })
    .then(response => {
      const data = response.data

      if(lang.value.length === 0) {
        lang.value[userLang] = data
      } else {
        for(let item in data) {
          lang.value[userLang][item] = data[item]
        }
      }
    })
    .catch(error => {
      console.error('Error:', error)
    })
}

export { lang, fetchLang }