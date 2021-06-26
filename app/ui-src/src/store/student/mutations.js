import { 
  bearerToken,
  admin,
  flashAlert
} from '../../composables/common'

const mutations = {
  showDeleteConfirm(state, id) {

  },
  getDetail(state, id) {

  },
  getClassGroup(state) {
    admin.get(`${state.studentApi}get-kelas`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        state.classGroupList = response.data
      })
  },
  selectAll(state) {
    if (state.checkAll) {
      state.paging.data.forEach(item => {
        state.selectedStudents.push(item.student_id)
      })
    } else {
      state.selectedStudents = []
    }
  } 
}

export default mutations