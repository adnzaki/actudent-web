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

        const data = response.data

        if(data.status === 'true') {
          presenceUrl = `${baseUrl}${data.id}/${date}`
          state.presenceButtons = true
        } else {
          state.presenceButtons = false
        }

        state.journalStatus = data.status
        state.journalID = data.id

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