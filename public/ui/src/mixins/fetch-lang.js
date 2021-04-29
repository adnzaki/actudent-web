import { appConfig as conf } from '../../actudent.config'
import { Cookies } from 'quasar'
import { core } from 'boot/axios'
import { bearerToken } from '../composables/validate-token'

const locale = {
  data () {
    return {
      lang: []
    }
  },
  methods: {
    fetchLang (file) {
      core.get(`get-lang/${file}`, {
        headers: {
          Authorization: bearerToken
        }
      })
        .then(response => {
          const data = response.data
          if(this.lang.length === 0) {
						this.lang = data
					} else {
						for(let item in data) {
							this.lang[item] = data[item]
						}
					}
        })
        .catch(error => {
          console.error('Error:', error)
        })
    }
  }
}

export default locale
