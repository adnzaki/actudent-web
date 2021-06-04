import { conf, bearerToken } from '../composables/common'

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
          Authorization: bearerToken
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
