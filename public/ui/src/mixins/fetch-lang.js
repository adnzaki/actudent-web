import { appConfig as conf } from '../../actudent.config'
// import { redirect } from '../composables/validate-token'

const locale = {
  data () {
    return {
      lang: []
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
