import { 
  Cookies,
  conf,
  bearerToken,
  admin,
  timeout,
  errorNotif,
  createFormData,
  pengguna,
  t
} from '../../composables/common'

import { Notify } from 'quasar'

export default {
  checkJournal({ state, commit }, date) {
    admin.get(`${state.presenceApi}cek-jurnal/${state.scheduleID}/${date}`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        const baseUrl = `${state.presenceApi}get-absen/${state.classID}/`
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
}