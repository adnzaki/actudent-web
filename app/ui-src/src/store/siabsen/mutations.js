import { bearerToken, siabsen } from 'src/composables/common'

export default {
  getTeacherStatus(state, tag) {
    siabsen.get(`status-${tag}`, {
      headers: { Authorization: bearerToken }
    })
      .then(({ data }) => {
        const canAbsent = data.canAbsent === 1 ? true : false
        if(tag === 'masuk') {
          state.inStatus = data.status
          state.canInAbsent = canAbsent
          state.isLate = data.late === 1 ? true : false
        } else {
          state.outStatus = data.status
          state.canOutAbsent = canAbsent
        }
      })
  },
  getConfig(state) {
    siabsen.get('get-config', {
      headers: { Authorization: bearerToken }
    })
      .then(({ data }) => {
        state.config = data
      })
  }
}
