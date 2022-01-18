import { 
  bearerToken,
  admin,
  flashAlert,
  t,
} from '../../composables/common'

export default {
  getPresence(state, url) {
    admin.get(url, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        state.presenceList = response.data
      })
  },
  getSchedules(state, payload) {
    admin.get(`${state.presenceApi}get-jadwal/${payload.day}/${payload.grade}`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        state.schedule = response.data
      })
  }
}