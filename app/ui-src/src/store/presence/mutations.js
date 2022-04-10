import { 
  bearerToken,
  axios,
  flashAlert,
  t,
  admin
} from '../../composables/common'

export default {
  getClassName(state, id) {
    admin.get(`kelas/detail/${id}`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        state.className = response.data.grade_name
      })
  },
  multiPresence(state, callback) {
    if(state.studentPresence.length > 0) {
      callback()
    } else {
      flashAlert(t('pilih_data'), 'negative')
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