import { 
  bearerToken,
  admin,
  flashAlert,
  t
} from '../../composables/common'

export default {
  showMappingForm(state, day) {
    state.schedule.lessonsInput = []
    state.schedule.showForm = true
    state.schedule.selectedDay = day
    if (state.schedule.list[day].length > 0) {
      let jadwal = state.schedule.list[day]
      jadwal.forEach((item, index) => {
        let satuan, ruang, scheduleIndex
        if (item.lesson_code !== 'REST') {
          satuan = t('jadwal_jam_pelajaran')
          ruang = ` - ${item.room_name}`
          scheduleIndex = index
        } else {
          item.lessons_grade_id = 'null'
          item.schedule_id = `break-${index}`
          satuan = t('jadwal_menit')
          ruang = ''
          scheduleIndex = 'null'
        }

        state.schedule.lessonsInput.push({
          id: item.schedule_id,
          val: item.lessons_grade_id,
          room: item.room_id,
          text: `${item.lesson_name} (${item.duration} ${satuan}${ruang})`,
          duration: item.duration,
          index: scheduleIndex
        })
      })
    }
  },
  getSchedules(state, grade) {
    admin.get(`${state.scheduleApi}get-jadwal/${grade}`, {
      headers: { Authorization: bearerToken },
    })
      .then(response => {
        state.schedule.list = response.data.schedule
        state.className = response.data.class_name
      })
  },
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
        state.className = response.data.class_name
      })
  },
}