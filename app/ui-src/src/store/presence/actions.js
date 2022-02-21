import { 
  Cookies,
  conf,
  bearerToken,
  axios,
  timeout,
  errorNotif,
  createFormData,
  pengguna,
  t
} from '../../composables/common'

import { Notify } from 'quasar'

export default {
  copyJournal({ state, dispatch, getters }) {
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('absensi_salin_jurnal_progress'),
      color: 'info',
      position: 'center',
      timeout,
    })

    axios.get(`${getters.presenceApi}salin-jurnal/${state.scheduleID}/${state.helper.activeDate}`, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(res => {
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
      due_date: state.journal.due_date
    }

    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('absensi_jurnal_save_progress'),
      color: 'info',
      position: 'center',
      timeout,
    })

    axios.post(`${baseUrl}/${includeHomework}`, data, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(res => {
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
          dispatch('checkJournal', state.helper.activeDate)
        }
      })
  },
  checkJournal({ state, commit, getters, dispatch }, date) {
    // set active date based on selected schedule
    state.helper.activeDate = date

    axios.get(`${getters.presenceApi}cek-jurnal/${state.scheduleID}/${date}`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        const baseUrl = `${getters.presenceApi}get-absen/${state.classID}/`
        let presenceUrl = `${baseUrl}null/null`

        const data = response.data

        if(data.status === 'true') {
          presenceUrl = `${baseUrl}${data.id}/${date}`
          state.presenceButtons = true
        } else {
          state.presenceButtons = false
        }

        state.journalStatus = data.status
        state.journalID = data.id

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
  getSchedules({ state, getters, dispatch }, payload) {
    axios.get(`${getters.presenceApi}get-jadwal/${payload.day}/${payload.grade}`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        state.schedule = response.data
        if(state.schedule.length > 0) {
          state.scheduleID = state.schedule[0].id
          dispatch('checkJournal', payload.date)
        }
      })
  }
}