import { 
  bearerToken,
  axios,
  timeout,
  createFormData,
  t,
} from '../../composables/common'

export default {
  getEvents({ state, getters, dispatch }, { view, start, end }) {
    axios.get(`${getters.agendaApi}get-events/${start}/${end}`, {
      headers: { Authorization: bearerToken }
    })
      .then(({ data }) => {
        state.events = data
      })
  }
}
