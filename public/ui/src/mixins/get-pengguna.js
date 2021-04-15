import { appConfig as conf } from '../../actudent.config'
import { Cookies } from 'quasar'

const getPengguna = {
  data() {
    return {
      pengguna: {}
    }
  },
  methods: {
    getPengguna () {
      fetch(`${conf.coreAPI}pengguna`, {
        method: 'GET',
        mode: 'cors',
        headers: {
          Authorization: `Bearer ${Cookies.get(conf.cookieName)}`
        }
      })
        .then(response => response.json())
        .then(data => {
          this.pengguna = data
        })
        .catch((error) => {
          console.error('Error:', error)
        })
    },
  }
}

export default getPengguna
