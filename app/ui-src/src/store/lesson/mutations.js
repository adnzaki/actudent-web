import { 
  bearerToken,
  admin,
  flashAlert,
  t
} from '../../composables/common'

export default {
  getDetail(state, id) {
    // state.error = {}
    // state.showEditForm = true
    // admin.get(`${state.roomApi}detail/${id}`, {
    //   headers: { Authorization: bearerToken }
    // })
    //   .then(response => {
    //     state.detail = response.data
    //   })
  },
  closeDeleteConfirm(state) {
    state.selectedLessons = []
    state.deleteConfirm = false
    state.checkAll = false
  },
  showDeleteConfirm(state, id) {
    state.selectedLessons = []
    state.selectedLessons.push(id)
    state.deleteConfirm = true
  },
  selectAll(state) {
    if (state.checkAll) {
      state.paging.data.forEach(item => {
        state.selectedLessons.push(item.lesson_id)
      })
    } else {
      state.selectedLessons = []
    }
  },
  multipleDeleteConfirm(state) {
    if(state.selectedLessons.length > 0) {
      state.deleteConfirm = true
    } else {
      flashAlert(t('pilih_data_dulu'), 'negative')
    }
  },
}