import { 
  Cookies,
  conf,
  bearerToken,
  admin,
  timeout,
  errorNotif,
  createFormData,
  pengguna,
  t,
} from '../../composables/common'

import { Notify } from 'quasar'

export default {
  saveSchedules({ state, commit }) {
    let data = JSON.stringify(state.schedule.lessonsInput),
        toBeDeleted = JSON.stringify(state.schedule.toBeDeletedSchedule)

    const schedules = { jadwal:  data, hapus: toBeDeleted }

    state.helper.disableSaveButton = true
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('jadwal_save_progress'),
      color: 'info',
      position: 'center',
      timeout,
    })

    admin.post(`${state.scheduleApi}simpan-jadwal/${state.schedule.selectedDay}`, schedules, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(() => {
        state.helper.disableSaveButton = false

        // hide all forms
        state.schedule.showLessonInput = false
        state.schedule.showBreakInput = false
        state.schedule.showInactiveInput = false

        // show the lesson list
        state.schedule.showLessonList = true

        state.schedule.isBreak = false  
        state.schedule.lessonsInput = []
        state.schedule.toBeDeletedSchedule = []
        state.schedule.breakDuration = 0
        state.schedule.scheduleType = 'lesson'

        notifyProgress({
          message: t('jadwal_save_success'),
          color: 'positive',
          icon: 'done',
          spinner: false
        })

        commit('getSchedules', state.classID)
        state.schedule.showForm = false
      })
  },
  deleteLesson({ state, dispatch }) {
    let idString
    if(state.lesson.selected.length > 1) {
      idString = state.lesson.selected.join('-')
    } else {
      idString = state.lesson.selected[0]
    }

    state.helper.disableSaveButton = true

    // show notify
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('progress_hapus'),
      color: 'info',
      position: 'center',
      timeout,
    })

    const data = { id: idString }
    admin.post(`${state.scheduleApi}hapus-mapel`, data, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(() => {
        state.helper.disableSaveButton = false
        state.deleteConfirm = false
        state.lesson.checkAll = false
        notifyProgress({
          message: t('jadwal_delete_success'),
          color: 'positive',
          icon: 'done',
          spinner: false
        })

        // refresh data
        dispatch('resetForm', state.classID)
      })
  },
  saveLesson({ state, dispatch }, payload) {
    // default URL (not edit)
    let url = `simpan-mapel/${state.classID}`

    // if it is edit form
    if(payload.edit) url = `${url}/${payload.id}`

    state.helper.disableSaveButton = true
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('jadwal_save_lesson_progress'),
      color: 'info',
      position: 'center',
      timeout,
    })

    admin.post(`${state.scheduleApi}${url}`, payload.data, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(response => {
        state.helper.disableSaveButton = false
        const res = response.data
        if(res.code === '500') {
          state.error = res.msg
          notifyProgress({
            message: `Error! ${t('jadwal_save_error')}`,
            color: 'negative',
            spinner: false
          })
        } else {
          state.lesson.saveStatus = 200

          dispatch('resetForm', state.classID)
          if(payload.edit) {
            state.lesson.showEditForm = false
            notifyProgress({
              message: `${t('sukses')} ${t('jadwal_edit_success')}`,
              color: 'positive',
              icon: 'done',
              spinner: false
            })
          } else {
            state.lesson.showAddForm = false
            notifyProgress({
              message: `${t('sukses')} ${t('jadwal_insert_success')}`,
              color: 'positive',
              icon: 'done',
              spinner: false
            })
          }
        }
      })
  },
  resetForm({ state, commit }, grade) {
    state.error = {}
    state.current = 1
    commit('getLessonsList', grade)
    commit('getLessonOptions', grade)
  },
  getClassList({ state, dispatch }) {
    dispatch('getData', {
      token: bearerToken,
      lang: Cookies.get(conf.userLang),
      limit: 10,
      offset: state.current - 1,
      orderBy: 'grade_name',
      searchBy: 'grade_name',
      sort: 'ASC',
      search: '',
      url: `${conf.adminAPI}kelas/get-kelas/`,
      autoReset: {
        active: true,
        timeout: 500
      },
    })
  },
}