import { 
  Cookies,
  conf,
  bearerToken,
  axios,
  timeout,
  errorNotif,
  createFormData,
  pengguna,
  t
} from '../../composables/common'

import { Notify } from 'quasar'

export default {
  checkJournal({ state, commit, getters }, date) {
    axios.get(`${getters.presenceApi}cek-jurnal/${state.scheduleID}/${date}`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        const baseUrl = `${getters.presenceApi}get-absen/${state.classID}/`
        let presenceUrl = `${baseUrl}null/null`

        if(response.data.status === 'true') {
          presenceUrl = `${baseUrl}${response.data.id}/${date}`
          state.presenceButtons = true
        } else {
          state.presenceButtons = false
        }

        commit('getPresence', presenceUrl)
      })
  },
  getSchedules({ state, getters }, payload) {
    axios.get(`${getters.presenceApi}get-jadwal/${payload.day}/${payload.grade}`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        state.schedule = response.data
      })
  }
}