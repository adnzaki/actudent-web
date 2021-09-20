import { 
  bearerToken,
  admin,
  flashAlert,
  t
} from '../../composables/common'

export default {
  getDetail(state, id) {
    state.error = {}
    state.showEditForm = true
    admin.get(`${state.roomApi}detail/${id}`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        state.detail = response.data
      })
  },
  showDeleteConfirm(state, id) {
    state.selectedRooms = []
    state.selectedRooms.push(id)
    state.deleteConfirm = true
  },
  selectAll(state) {
    if (state.checkAll) {
      state.paging.data.forEach(item => {
        state.selectedRooms.push(item.grade_id)
      })
    } else {
      state.selectedRooms = []
    }
  },
  multipleDeleteConfirm(state) {
    if(state.selectedRooms.length > 0) {
      state.deleteConfirm = true
    } else {
      flashAlert(t('pilih_data_dulu'), 'negative')
    }
  },
}