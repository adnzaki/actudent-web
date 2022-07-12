import { bearerToken, siabsen } from 'src/composables/common'

export default {
  closeDeleteConfirm(state) {
    state.selectedPermission = null
    state.deleteConfirm = false
    state.disableSaveButton = true
  },
  getDetailPresence(state, { staffId, userId, period }) {
    siabsen.get(`detail-absensi/${staffId}/${userId}/${period}`, {
      headers: { Authorization: bearerToken }
    })
    .then(({ data }) => {
      state.presenceDetail = data
    })
  },
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
          state.absenceIn = data.timeIn
        } else {
          state.outStatus = data.status
          state.canOutAbsent = canAbsent
          state.absenceOut = data.timeOut
        }
      })
  },
  getDetailConfig(state) {
    siabsen.get('get-detail-config', {
      headers: { Authorization: bearerToken }
    })
      .then(({ data }) => {
        state.presenceConfig = data
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
