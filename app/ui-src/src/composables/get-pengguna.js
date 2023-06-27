import { core } from 'boot/axios'
import { bearerToken } from './subscription'
import { ref } from 'vue'

const pengguna = ref({})

function getPengguna() {
  core.get('pengguna', {
    headers: {
      Authorization: bearerToken
    }
  })
    .then(response => {
      pengguna.value = response.data
    })
    .catch((error) => {
      console.error('Error:', error)
    })
}

export { pengguna, getPengguna }
