import { bearerToken, siabsen } from 'src/composables/common'

export default {
  getConfig(state) {
    siabsen.get('get-config', {
      headers: { Authorization: bearerToken }
    })
      .then(({ data }) => {
        state.config = data
      })
  }
}
