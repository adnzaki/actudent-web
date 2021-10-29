import { 
  bearerToken,
  admin,
  flashAlert,
  t
} from '../../composables/common'

export default {
  getLessonsList(state, grade) {
    admin.get(`${state.scheduleApi}daftar-mapel/${grade}`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        state.lesson.list = response.data
      })
  },
}