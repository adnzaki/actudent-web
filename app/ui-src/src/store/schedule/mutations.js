import { 
  bearerToken,
  admin,
  flashAlert,
  t
} from '../../composables/common'

export default {
  getLessonsForSchedule(state, grade) {
    admin.get(`${state.scheduleApi}get-pilihan-mapel/${grade}`, {
      headers: { Authorization: bearerToken },
    })
      .then(response => {
        state.schedule.normalList = response.data.normalList
        state.schedule.inactiveList = response.data.inactiveList

        // default lesson options
        state.schedule.lessonOptions = state.schedule.normalList
      })
  },
  removeLesson(state, id) {
    // Remove item from state.schedule.lessonsInput
    let lessons = state.schedule.lessonsInput,
        index = lessons.findIndex(el => {
          return el.id === id
        })
    lessons.splice(index, 1)

    // If they are existing data from server,
    // send them to state.schedule.toBeDeletedSchedule
    if (id.match(/break/) === null && id.match(/new/) === null) {
      state.schedule.toBeDeletedSchedule.push(id)
    }
  },
  pushLesson(state, data) {
    let schedule, index = 0

    if (state.schedule.lessonsInput.length > 0) {
      index = state.schedule.lessonsInput.length
    }

    if(!state.schedule.isBreak) {
      let lesson = data.lesson,
          room = data.room,
          duration = data.duration

      let scheduleID, lessonGradeID
      if (state.schedule.scheduleType === 'lesson') {
        scheduleID = `new-${index}`
        lessonGradeID = lesson.value
      } else {
        const split = lesson.value.split('-')
        
        scheduleID = `inactive-${split[0]}`
        lessonGradeID = split[1]
      }

      schedule = { 
        id: scheduleID,
        val: lessonGradeID, // lessons_grade_id
        room: room.value, // room_id
        text: `${lesson.label} (${duration.label} - ${room.label})`,
        duration: duration.value,
        index
      }
    } else {
      schedule = {
        id: `break-${index}`,
        val: 'null',
        room: 'null',
        text: `${t('jadwal_istirahat')} (${data} ${t('jadwal_menit')})`,
        duration: data,
        index: 'null'
      }
    }

    state.schedule.lessonsInput.push(schedule)

    // reset all state into their default value
    state.schedule.showLessonInput = false
    state.schedule.isBreak = false
    state.schedule.showLessonList = true
    state.schedule.scheduleType = 'lesson'
    state.helper.disableSaveButton = false
  },
  getRooms(state) {
    admin.get(`${state.scheduleApi}get-ruang`, {
      headers: { Authorization: bearerToken },
    })
      .then(response => {
        state.rooms = response.data
      })
  },
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
          item.lessons_grade_id = null
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
        
        state.classID = grade
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