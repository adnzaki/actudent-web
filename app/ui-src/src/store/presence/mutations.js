import { 
  bearerToken,
  admin,
  flashAlert,
  t,
} from '../../composables/common'

export default {
  getSchedules(state, payload) {
    admin.get(`${state.presenceApi}get-jadwal/${payload.day}/${payload.grade}`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        state.schedule = response.data
      })
  }
}