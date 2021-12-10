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
    state.classID = grade
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
  multipleDeleteConfirm(state) {
    if(state.lesson.selected.length > 0) {
      state.deleteConfirm = true
    } else {
      flashAlert(t('pilih_data_dulu'), 'negative')
    }
  },
  closeDeleteConfirm(state) {
    state.lesson.selected = []
    state.deleteConfirm = false
    state.checkAll = false
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