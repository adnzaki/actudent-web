import { 
  bearerToken,
  axios,
  flashAlert,
  t,
} from '../../composables/common'

export default {
  multiPresence(state, callback) {
    if(state.studentPresence.length > 0) {
      callback()
    } else {
      flashAlert(t('pilih_data_dulu'), 'negative')
    }
  },
  selectAll(state) {
    if (state.checkAll) {
      state.presenceList.forEach(item => {
        state.studentPresence.push(item.id)
      })
    } else {
      state.studentPresence = []
    }
  },
  getPresence(state, url) {
    axios.get(url, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        state.presenceList = response.data
      })
  },
}