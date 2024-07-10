import { core } from 'boot/axios'
import { bearerToken } from './subscription'
import { ref } from 'vue'

const pengguna = ref({})

function getPengguna(next = null) {
  core
    .get('pengguna', {
      headers: {
        Authorization: bearerToken,
      },
    })
    .then(({ data }) => {
      pengguna.value = data
      if (next !== null) next(data)
    })
    .catch((error) => {
      console.error('Error:', error)
    })
}

export { pengguna, getPengguna }
