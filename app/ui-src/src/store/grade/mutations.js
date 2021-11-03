import { 
  bearerToken,
  admin,
  flashAlert,
  t
} from '../../composables/common'

export default {
  getClassMember(state, id) {
    admin.get(`${state.classApi}get-member/${id}`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        state.classMember.students = response.data
      })
  },
  getTeacher(state) {
    admin.get(`${state.classApi}cari-guru`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        state.teachers = response.data
      })     
  },
  getDetail(state, id) {
    state.error = {}
    state.showEditForm = true
    admin.get(`${state.classApi}detail/${id}`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        const res = response.data
        state.detail = res
        state.classMember.name = res.grade_name
        state.selectedTeacher.id = res.teacher_id
        state.selectedTeacher.name = res.staff_name
      })
  },
  closeDeleteConfirm(state) {
    state.selectedClasses = []
    state.deleteConfirm = false
    state.checkAll = false
  },
  multipleDeleteConfirm(state) {
    if(state.selectedClasses.length > 0) {
      state.deleteConfirm = true
    } else {
      flashAlert(t('pilih_data_dulu'), 'negative')
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
