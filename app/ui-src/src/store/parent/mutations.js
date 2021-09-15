import { 
  bearerToken,
  admin,
  flashAlert,
  t,
} from '../../composables/common'

export default {
  getDetail(state, id) {
    state.error = {}
    state.showEditForm = true
    admin.get(`${state.parentApi}detail/${id}`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        state.detail = response.data.parent  
        state.children = response.data.children  
      })
  },
  multipleDeleteConfirm(state) {
    if(state.selectedParents.length > 0) {
      state.deleteConfirm = true
    } else {
      flashAlert(t('pilih_data_dulu'), 'negative')
    }
  },
  showDeleteConfirm(state, id) {
    state.selectedParents = []
    state.selectedParents.push(id)
    state.deleteConfirm = true
  },
  closeDeleteConfirm(state) {
    state.selectedParents = []
    state.deleteConfirm = false
    state.checkAll = false
  },
  selectAll(state) {
    if (state.checkAll) {
      state.paging.data.forEach(item => {
        state.selectedParents.push(`${item.parent_id}-${item.user_id}`)
      })
    } else {
      state.selectedParents = []
    }
  } 
}
