import { appConfig as conf } from '../../actudent.config'
// import { redirect } from '../composables/validate-token'

const locale = {
  data () {
    return {
      lang: {}
    }
  },
  methods: {
    fetchLang (file) {
      fetch(`${conf.coreAPI}get-lang/${file}`, {
        method: 'GET',
        mode: 'cors',
        headers: {
          Authorization: `Bearer ${conf.testToken}`
        }
      })
        .then(response => response.json())
        .then(data => {
          this.lang = data
        })
        .catch((error) => {
          console.error('Error:', error)
        })
    }
  }
}

export default locale
