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
    admin.get(`${state.employeeApi}detail/${id}`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        state.detail = response.data
        state.helper.filename = response.data.staff_photo
      })
  },
  showDeleteConfirm(state, payload) {
    state.selectedEmployees = []
    state.selectedEmployees.push(`${payload.staff}-${payload.user}`)
    state.deleteConfirm = true
  },
  multipleDeleteConfirm(state) {
    if(state.selectedEmployees.length > 0) {
      state.deleteConfirm = true
    } else {
      flashAlert(t('pilih_data_dulu'), 'negative')
    }
  },  
  closeDeleteConfirm(state) {
    state.selectedEmployees = []
    state.deleteConfirm = false
    state.checkAll = false
  },
  uploadImage(state, val) {
    state.helper.disableSaveButton = true
    const formData = new FormData()
    formData.append('staff_photo', val)
    admin.post(`${state.employeeApi}validate-file`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
        Authorization: bearerToken
      }
    })
      .then(response => {
        if(response.data.msg === 'OK') {
          state.error.featured_image = ''
          state.error.staff_photo = ''
          state.helper.disableSaveButton = false
          state.helper.validImage = true
          state.helper.filename = response.data.img
        } else {
          state.error = response.data
          state.helper.disableSaveButton = true
        }
      })
      .catch(error => console.error(error))
  },
  selectAll(state) {
    if (state.checkAll) {
      state.paging.data.forEach(item => {
        state.selectedEmployees.push(`${item.staff_id}-${item.user_id}`)
      })
    } else {
      state.selectedEmployees = []
    }
  } 
}
