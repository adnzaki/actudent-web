import { ref } from 'vue'
import { core } from 'boot/axios'
import { bearerToken } from 'src/composables/validate-token'
import { Cookies } from 'quasar'
import { appConfig as conf } from '../../actudent.config'

const lang = ref({
  english: [],
  indonesia: []
})

const fetchLoginLang = lang => {
  core.get(`get-login-lang/${lang}`)
      .then(response => {
        pushLang(response.data, lang)
      })
      .catch(error => {
        console.error('Error:', error)
      })
}

const fetchLang = (file, selectedLang) => {
  if(Cookies.get(conf.cookieName) !== null) {
    core.get(`get-lang/${file}/${selectedLang}`, {
      headers: {
        Authorization: bearerToken
      }
    })
      .then(response => {
        pushLang(response.data, selectedLang)
      })
      .catch(error => {
        console.error('Error:', error)
      })
  }
}

const pushLang = (data, selectedLang) => {  
  if(lang.value.length === 0) {
    lang.value[selectedLang] = data
  } else {
    for(let item in data) {
      lang.value[selectedLang][item] = data[item]
    }
  }
}

export { lang, fetchLang, fetchLoginLang }