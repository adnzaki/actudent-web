import {
  Cookies,
  conf,
  bearerToken,
  admin,
  timeout,
  createFormData,
  t,
} from '../../composables/common'

import { Notify, Dialog } from 'quasar'
import { usePagingStore as paging } from 'ss-paging-vue'

export default {
  saveSettings() {
    const data = {
      lesson_hour: this.schedule.allocation,
      start_time: this.schedule.startTime,
      start_time_2: this.schedule.startTime2,
    }

    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('jadwal_update_setting_progress'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    admin
      .post(`${this.scheduleApi}simpan-pengaturan`, data, {
        headers: { Authorization: bearerToken },
        transformRequest: [
          (data) => {
            return createFormData(data)
          },
        ],
      })
      .then((res) => {
        notifyProgress({ timeout })
        if (res.code === '500') {
          this.error = res.msg
          notifyProgress({
            message: `Error! ${t('jadwal_unable_update_setting')}`,
            color: 'negative',
            spinner: false,
          })
        } else {
          this.showSettingsForm = false

          notifyProgress({
            message: t('jadwal_success_update_setting'),
            color: 'positive',
            icon: 'done',
            spinner: false,
          })
        }
      })
  },
  saveSchedules(gradeId) {
    let data = JSON.stringify(this.schedule.lessonsInput),
      toBeDeleted = JSON.stringify(this.schedule.toBeDeletedSchedule)

    const schedules = { jadwal: data, hapus: toBeDeleted, grade: gradeId }

    this.helper.disableSaveButton = true
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('jadwal_save_progress'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    admin
      .post(
        `${this.scheduleApi}simpan-jadwal/${this.schedule.selectedDay}`,
        schedules,
        {
          headers: { Authorization: bearerToken },
          transformRequest: [
            (data) => {
              return createFormData(data)
            },
          ],
        },
      )
      .then(() => {
        notifyProgress({ timeout })
        this.helper.disableSaveButton = false

        // hide all forms
        this.schedule.showLessonInput = false
        this.schedule.showBreakInput = false
        this.schedule.showInactiveInput = false

        // show the lesson list
        this.schedule.showLessonList = true

        this.schedule.isBreak = false
        this.schedule.lessonsInput = []
        this.schedule.toBeDeletedSchedule = []
        this.schedule.breakDuration = 0
        this.schedule.scheduleType = 'lesson'

        notifyProgress({
          message: t('jadwal_save_success'),
          color: 'positive',
          icon: 'done',
          spinner: false,
        })

        this.getSchedules(this.classID)
        this.getLessonsForSchedule(this.classID)
        this.schedule.showForm = false
      })
  },
  deleteLesson() {
    let idString
    if (this.lesson.selected.length > 1) {
      idString = this.lesson.selected.join('-')
    } else {
      idString = this.lesson.selected[0]
    }

    this.helper.disableSaveButton = true

    // show notify
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('progress_hapus'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    const data = { id: idString }
    admin
      .post(`${this.scheduleApi}hapus-mapel`, data, {
        headers: { Authorization: bearerToken },
        transformRequest: [
          (data) => {
            return createFormData(data)
          },
        ],
      })
      .then(() => {
        this.helper.disableSaveButton = false
        this.deleteConfirm = false
        this.lesson.checkAll = false
        notifyProgress({
          message: t('jadwal_delete_success'),
          color: 'positive',
          icon: 'done',
          spinner: false,
          timeout,
        })

        // refresh data
        this.resetForm(this.classID)
      })
  },
  saveLesson(payload) {
    // default URL (not edit)
    let url = `simpan-mapel/${this.classID}`

    // if it is edit form
    if (payload.edit) url = `${url}/${payload.id}`

    this.helper.disableSaveButton = true
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('jadwal_save_lesson_progress'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    admin
      .post(`${this.scheduleApi}${url}`, payload.data, {
        headers: { Authorization: bearerToken },
        transformRequest: [
          (data) => {
            return createFormData(data)
          },
        ],
      })
      .then((response) => {
        notifyProgress({ timeout })
        this.helper.disableSaveButton = false
        const res = response.data
        if (res.code === '500') {
          this.error = res.msg
          notifyProgress({
            message: `Error! ${t('jadwal_save_error')}`,
            color: 'negative',
            spinner: false,
          })
        } else {
          this.lesson.saveStatus = 200

          this.resetForm(this.classID)
          if (payload.edit) {
            this.lesson.showEditForm = false
            notifyProgress({
              message: `${t('sukses')} ${t('jadwal_edit_success')}`,
              color: 'positive',
              icon: 'done',
              spinner: false,
            })
          } else {
            this.lesson.showAddForm = false
            notifyProgress({
              message: `${t('sukses')} ${t('jadwal_insert_success')}`,
              color: 'positive',
              icon: 'done',
              spinner: false,
            })
          }
        }
      })
  },
  resetForm(grade) {
    this.error = {}
    this.current = 1
    this.getLessonsList(grade)
    this.getLessonOptions(grade)
  },
  getClassList() {
    const limit = 25
    paging().state.rows = limit

    paging().getData({
      token: bearerToken,
      lang: localStorage.getItem(conf.userLang),
      limit,
      offset: this.current - 1,
      orderBy: 'grade_name',
      searchBy: 'grade_name',
      sort: 'ASC',
      search: '',
      url: `${conf.adminAPI}jadwal/get-kelas/`,
      autoReset: {
        active: true,
        timeout: 500,
      },
    })
  },

  switchShift(gradeId) {
    Dialog.create({
      title: t('konfirmasi'),
      message: t('jadwal_tukar_shift_confirm'),
      cancel: t('batal'),
      persistent: true,
    }).onOk(() => {
      const notifyProgress = Notify.create({
        group: false,
        spinner: true,
        message: t('jadwal_tukar_shift_progress'),
        color: 'info',
        position: 'center',
        timeout: 0,
      })

      admin
        .get(`${this.scheduleApi}tukar-shift/${gradeId}`, {
          headers: { Authorization: bearerToken },
        })
        .then(({ data }) => {
          this.getClassList()
          notifyProgress({ timeout })
          notifyProgress({
            message: `${t('sukses')} ${t('jadwal_tukar_shift_success')}`,
            color: 'positive',
            icon: 'done',
            spinner: false,
          })
        })
        .catch((error) => {
          notifyProgress({
            message: `Error! ${error}`,
            color: 'negative',
            spinner: false,
          })
        })
    })
  },
  getSettings() {
    admin
      .get(`${this.scheduleApi}get-pengaturan`, {
        headers: { Authorization: bearerToken },
      })
      .then((response) => {
        this.schedule.allocation = response.data.alokasi
        this.schedule.startTime = response.data.mulai1
        this.schedule.startTime2 = response.data.mulai2
      })
  },
  getLessonsForSchedule(grade) {
    admin
      .get(`${this.scheduleApi}get-pilihan-mapel/${grade}`, {
        headers: { Authorization: bearerToken },
      })
      .then((response) => {
        this.schedule.normalList = response.data.normalList
        this.schedule.inactiveList = response.data.inactiveList

        // default lesson options
        this.schedule.lessonOptions = this.schedule.normalList
        if (this.schedule.lessonOptions.length > 0) {
          this.schedule.defaultLesson = {
            label: this.schedule.lessonOptions[0].text,
            value: this.schedule.lessonOptions[0].id,
          }
        }
      })
  },
  removeLesson(id) {
    // Remove item from this.schedule.lessonsInput
    let lessons = this.schedule.lessonsInput,
      index = lessons.findIndex((el) => {
        return el.id === id
      })
    lessons.splice(index, 1)

    // If they are existing data from server,
    // send them to this.schedule.toBeDeletedSchedule
    if (id.match(/break/) === null && id.match(/new/) === null) {
      this.schedule.toBeDeletedSchedule.push(id)
    }
  },
  pushLesson(data) {
    let schedule,
      index = 0

    if (this.schedule.lessonsInput.length > 0) {
      index = this.schedule.lessonsInput.length
    }

    if (!this.schedule.isBreak) {
      let lesson = data.lesson,
        room = data.room,
        duration = data.duration

      let scheduleID, lessonGradeID
      if (this.schedule.scheduleType === 'lesson') {
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
        index,
      }
    } else {
      schedule = {
        id: `break-${index}`,
        val: 'null',
        room: 'null',
        text: `${t('jadwal_istirahat')} (${data} ${t('jadwal_menit')})`,
        duration: data,
        index: 'null',
      }
    }

    this.schedule.lessonsInput.push(schedule)

    // reset all state into their default value
    this.schedule.showLessonInput = false
    this.schedule.isBreak = false
    this.schedule.showLessonList = true
    this.schedule.scheduleType = 'lesson'
    this.helper.disableSaveButton = false
  },
  getRooms() {
    admin
      .get(`${this.scheduleApi}get-ruang`, {
        headers: { Authorization: bearerToken },
      })
      .then((response) => {
        this.rooms = response.data
        if (this.rooms.length > 0) {
          this.schedule.defaultRoom = {
            label: this.rooms[0].text,
            value: this.rooms[0].id,
          }
        }
      })
  },
  showMappingForm(day) {
    this.schedule.lessonsInput = []
    this.schedule.showForm = true
    this.schedule.selectedDay = day
    if (this.schedule.list[day].length > 0) {
      let jadwal = this.schedule.list[day]
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

        this.schedule.lessonsInput.push({
          id: item.schedule_id,
          val: item.lessons_grade_id,
          room: item.room_id,
          text: `${item.lesson_name} (${item.duration} ${satuan}${ruang})`,
          duration: item.duration,
          index: scheduleIndex,
        })
      })
    }
  },
  getSchedules(grade) {
    admin
      .get(`${this.scheduleApi}get-jadwal/${grade}`, {
        headers: { Authorization: bearerToken },
      })
      .then((response) => {
        this.schedule.list = response.data.schedule
        this.className = response.data.class_name

        this.classID = grade
      })
  },
  getDetailLesson(id) {
    admin
      .get(`${this.scheduleApi}detail-mapel/${id}`, {
        headers: { Authorization: bearerToken },
      })
      .then((response) => {
        this.lesson.detail = response.data
        setTimeout(() => {
          this.lesson.showEditForm = true
        }, 500)
      })
  },
  getLessonOptions(grade) {
    this.classID = grade

    admin
      .get(`${this.scheduleApi}pilihan-mapel/${grade}`, {
        headers: { Authorization: bearerToken },
      })
      .then((response) => {
        this.lesson.options = response.data
        if (response.data.length > 0) {
          this.lesson.lessonId = response.data[0].id
        }
      })
  },
  showDeleteConfirm(id) {
    this.lesson.selected = []
    this.lesson.selected.push(id)
    this.deleteConfirm = true
  },
  multipleDeleteConfirm() {
    if (this.lesson.selected.length > 0) {
      this.deleteConfirm = true
    } else {
      flashAlert(t('pilih_data_dulu'), 'negative')
    }
  },
  closeDeleteConfirm() {
    this.lesson.selected = []
    this.deleteConfirm = false
    this.checkAll = false
  },
  selectAllLessons() {
    if (this.lesson.checkAll) {
      this.lesson.list.forEach((item) => {
        this.lesson.selected.push(item.lessons_grade_id)
      })
    } else {
      this.lesson.selected = []
    }
  },
  getLessonsList(grade) {
    admin
      .get(`${this.scheduleApi}daftar-mapel/${grade}`, {
        headers: { Authorization: bearerToken },
      })
      .then((response) => {
        this.lesson.list = response.data.lessons
        this.className = response.data.class_name
      })
  },
}
