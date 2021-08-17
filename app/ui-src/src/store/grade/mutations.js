import { 
  bearerToken,
  admin,
  flashAlert
} from '../../composables/common'

const mutations = {
  getDetail(state, id) {
    state.error = {}
    state.showEditForm = true
    admin.get(`${state.classApi}detail/${id}`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        const res = response.data
        state.detail = res
        state.selectedTeacher.id = res.teacher_id
        state.selectedTeacher.name = res.staff_name
      })
  },
  multipleDeleteConfirm(state, lang) {
    if(state.selectedClasses.length > 0) {
      state.deleteConfirm = true
    } else {
      flashAlert(lang.pilih_data_dulu, 'negative')
    }
  },
  showDeleteConfirm(state, id) {
    state.selectedClasses = []
    state.selectedClasses.push(id)
    state.deleteConfirm = true
  },
  selectAll(state) {
    if (state.checkAll) {
      state.paging.data.forEach(item => {
        state.selectedClasses.push(item.grade_id)
      })
    } else {
      state.selectedClasses = []
    }
  } 
}

export default mutations