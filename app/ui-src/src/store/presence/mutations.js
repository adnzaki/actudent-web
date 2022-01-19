import { 
  bearerToken,
  axios,
  flashAlert,
  t,
} from '../../composables/common'

export default {
  getPresence(state, url) {
    axios.get(url, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        state.presenceList = response.data
      })
  },
}