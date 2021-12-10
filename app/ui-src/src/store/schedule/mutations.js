import { 
  bearerToken,
  admin,
  flashAlert,
  t
} from '../../composables/common'

export default {
  getDetailLesson(state, id) {
    state.lesson.showEditForm = true
    admin.get(`${state.scheduleApi}detail-mapel/${id}`, {
      headers: { Authorization: bearerToken },
    })
      .then(response => {
        state.lesson.detail = response.data
      })
  },
  getLessonOptions(state, grade) {
    admin.get(`${state.scheduleApi}pilihan-mapel/${grade}`, {
      headers: { Authorization: bearerToken },
    })
      .then(response => {
        state.lesson.options = response.data
      })
  },
  showDeleteConfirm(state, id) {
    state.lesson.selected = []
    state.lesson.selected.push(id)
    state.deleteConfirm = true
  },
  selectAllLessons(state) {
    if(state.lesson.checkAll) {
      state.lesson.list.forEach(item => {
        state.lesson.selected.push(item.lessons_grade_id)
      })
    } else {
      state.lesson.selected = []
    }
  },
  getLessonsList(state, grade) {
    admin.get(`${state.scheduleApi}daftar-mapel/${grade}`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        state.lesson.list = response.data.lessons
      })
  },
}