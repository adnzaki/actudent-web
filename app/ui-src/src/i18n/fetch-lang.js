import { ref } from 'vue'
import { core } from 'boot/axios'
import { bearerToken } from 'src/composables/subscription'

const lang = ref({
  english: [],
  indonesia: []
})

const fetchLang = (file, selectedLang) => {
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

const pushLang = (data, selectedLang) => {
  if (lang.value.length === 0) {
    lang.value[selectedLang] = data
  } else {
    for (let item in data) {
      lang.value[selectedLang][item] = data[item]
    }
  }
}

export { lang, fetchLang }