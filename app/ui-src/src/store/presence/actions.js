import { 
  bearerToken,
  axios,
  timeout,
  createFormData,
  t,
} from '../../composables/common'

import { date } from 'quasar'

import { Notify } from 'quasar'

export default {
  getTeacherSchedules({ state, getters }) {
    axios.get(`${getters.presenceApi}daftar-jadwal/${state.helper.activeDay}`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        state.teacherSchedules = response.data
      })
  },
  getPeriodSummary({ state, getters }) {
    const period = `${state.selectedPeriod.semester}/${state.selectedPeriod.year}`
    state.showSpinner = true
    state.showPeriodTable = false
    state.showNoData = false

    axios.get(`${getters.presenceApi}rekap-semester/${state.classID}/${period}`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        state.periodSummary = response.data
        state.showSpinner = false

        // show the table only if data exists
        if(response.data.activeDays > 0) {
          state.showPeriodTable = true
        } else {
          state.showNoData = true
        }
      })
  },
  getMonthlySummary({ state, getters }) {
    const period = `${state.selectedPeriod.month}/${state.selectedPeriod.year}`
    state.showSpinner = true
    state.showMonthTable = false

    axios.get(`${getters.presenceApi}rekap-bulanan/${period}/${state.classID}`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        state.monthlySummary = response.data
        state.showSpinner = false
        state.showMonthTable = true
      })
  },
  submitPermission({ state, getters, dispatch }) {
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('absensi_izin_progress'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    axios.post(`${getters.presenceApi}izin`, { presence_mark: state.permissionNote }, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => createFormData(data)]
    })
      .then(response => {
        notifyProgress({ timeout })
        const res = response.data
        if(res.code === '500') {
          notifyProgress({
            message: `Error! ${res.msg.presence_mark}`,
            color: 'negative',
            spinner: false
          })
        } else {
          notifyProgress({ timeout: 1 })
          dispatch('savePresence', { status: 2 })
          state.showPermissionForm = false
          state.permissionNote = ''
        }
      })
  },
  savePresence({ state, getters, commit }, { status, studentId = null }) {
    let data = []
    const mark = state.permissionNote
    
    if(studentId === null) {
      state.studentPresence.forEach(id => {
        data.push({ status, mark, id })
      })
    } else {
      data = [{ status, mark, id: studentId }]
    }

    const absen = JSON.stringify(data)
    const url = `${getters.presenceApi}simpan-absen/${state.journalID}/${state.helper.activeDate}`

    axios.post(url, { absen }, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => createFormData(data)]
    })
      .then(() => {
        // empty presence list
        state.studentPresence = []

        // reset all students checkbox
        if(state.checkAll) state.checkAll = false

        // reload presence data
        commit('getPresence', state.presenceUrl)
      })
  },
  copyJournal({ state, dispatch, getters }) {
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('absensi_salin_jurnal_progress'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    axios.get(`${getters.presenceApi}salin-jurnal/${state.scheduleID}/${state.helper.activeDate}`, {
      headers: { Authorization: bearerToken }
    })
      .then(res => {
        notifyProgress({ timeout })
        if(res.data.status === 'OK') {
          state.journalID = res.data.id
          state.salinJurnal = false
          dispatch('getJournal', () => {
            notifyProgress({
              message: `${t('sukses')} ${res.data.msg}`,
              color: 'positive',
              icon: 'done',
              spinner: false
            })   
          })                 
        } else {          
          notifyProgress({
            message: `Error! ${res.data.msg}`,
            color: 'negative',
            spinner: false
          })
        }
      })
  },
  saveJournal({ state, dispatch, getters }) {
    const baseUrl = `${getters.presenceApi}save/${state.scheduleID}/${state.helper.activeDate}`
    const includeHomework = state.helper.homework ? 'true' : 'false'
    const data = {
      description: state.journal.description,
      homework_title: state.journal.homework_title,
      homework_description: state.journal.homework_description,
      due_date: date.formatDate(state.journal.due_date, 'YYYY-MM-DD')
    }

    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('absensi_jurnal_save_progress'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    axios.post(`${baseUrl}/${includeHomework}`, data, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(res => {
        notifyProgress({ timeout })
        if(res.data.code === '500') {
          state.error = res.data.msg
          notifyProgress({
            message: `Error! ${t('absensi_jurnal_error_save')}`,
            color: 'negative',
            spinner: false
          })
        } else {
          state.error = {}
          notifyProgress({
            message: `${t('sukses')} ${t('absensi_jurnal_success_save')}`,
            color: 'positive',
            icon: 'done',
            spinner: false
          })

          // reset everything
          state.showJournalForm = false
          state.journal = { 
            description: '',
            homework_title: '',
            homework_description: '',
            due_date: ''
          }
          dispatch('checkJournal')
        }
      })
  },
  checkJournal({ state, commit, getters, dispatch }) {
    axios.get(`${getters.presenceApi}cek-jurnal/${state.scheduleID}/${state.helper.activeDate}`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        const baseUrl = `${getters.presenceApi}get-absen/${state.classID}/`
        let presenceUrl = `${baseUrl}null/null`

        const data = response.data

        if(data.status === 'true') {
          presenceUrl = `${baseUrl}${data.id}/${state.helper.activeDate}`
          state.presenceButtons = true
        } else {
          state.presenceButtons = false
        }

        state.journalStatus = data.status
        state.journalID = data.id

        // save presence URL
        state.presenceUrl = presenceUrl

        commit('getPresence', presenceUrl)

        if(data.status === 'true') {
          state.salinJurnal = false
          dispatch('getJournal')
        } else {
          state.salinJurnal = true
          state.helper.homework = false
          state.journal = { 
            description: '',
            homework_title: '',
            homework_description: '',
            due_date: ''
          }
        }
      })
  },
  getJournal({ state, getters }, copyJournalCallback = false) {
    axios.get(`${getters.presenceApi}get-jurnal/${state.journalID}`, {
      headers: { Authorization: bearerToken }
    })
      .then(res => {
        state.journal.description = res.data.journal.description
        if(res.data.homework !== null) {
          // toggle homework checkbox
          state.helper.homework = true

          const hw = res.data.homework
          state.journal.homework_title = hw.homework_title
          state.journal.homework_description = hw.homework_description
          state.journal.due_date = hw.due_date
        } else {
          // reset if it has previously filled 
          state.helper.homework = false
          state.journal.homework_title = ''
          state.journal.homework_description = ''
          state.journal.due_date = ''
        }

        if(copyJournalCallback !== false) {
          copyJournalCallback()
        }
      })
  },
  getSchedules({ state, getters, dispatch }, grade) {
    axios.get(`${getters.presenceApi}get-jadwal/${state.helper.activeDay}/${grade}`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        state.schedule = response.data
        if(state.schedule.length > 0) {
          state.scheduleID = state.schedule[0].id
          state.showJournalBtn = true
          dispatch('checkJournal')
        }
      })
  }
}