import {
  t,
  admin,
  axios,
  teacher,
  timeout,
  bearerToken,
  createFormData,
} from '../../composables/common'

import { date } from 'quasar'
import { Notify } from 'quasar'

export default {
  canFillJournal() {
    axios
      .get(`${this.presenceApi}can-fill-journal/${this.helper.activeDate}`, {
        headers: { Authorization: bearerToken },
      })
      .then(({ data }) => {
        this.journalFillable = data.can_fill === 1 ? true : false
      })
  },
  getTeacherSchedules() {
    axios
      .get(`${this.presenceApi}daftar-jadwal/${this.helper.activeDay}`, {
        headers: { Authorization: bearerToken },
      })
      .then((response) => {
        this.teacherSchedules = response.data
      })
  },
  getPeriodSummary() {
    const period = `${this.selectedPeriod.semester}/${this.selectedPeriod.year}`
    this.showSpinner = true
    this.showPeriodTable = false
    this.showNoData = false

    axios
      .get(`${this.presenceApi}rekap-semester/${this.classID}/${period}`, {
        headers: { Authorization: bearerToken },
      })
      .then((response) => {
        this.periodSummary = response.data
        this.showSpinner = false

        // show the table only if data exists
        if (response.data.activeDays > 0) {
          this.showPeriodTable = true
        } else {
          this.showNoData = true
        }
      })
  },
  getMonthlySummary() {
    const period = `${this.selectedPeriod.month}/${this.selectedPeriod.year}`
    this.showSpinner = true
    this.showMonthTable = false

    axios
      .get(`${this.presenceApi}rekap-bulanan/${period}/${this.classID}`, {
        headers: { Authorization: bearerToken },
      })
      .then((response) => {
        this.monthlySummary = response.data
        this.showSpinner = false
        this.showMonthTable = true
      })
  },
  submitPermission() {
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('absensi_izin_progress'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    axios
      .post(
        `${this.presenceApi}izin`,
        { presence_mark: this.permissionNote },
        {
          headers: { Authorization: bearerToken },
          transformRequest: [(data) => createFormData(data)],
        },
      )
      .then((response) => {
        notifyProgress({ timeout })
        const res = response.data
        if (res.code === '500') {
          notifyProgress({
            message: `Error! ${res.msg.presence_mark}`,
            color: 'negative',
            spinner: false,
          })
        } else {
          notifyProgress({ timeout: 1 })
          this.savePresence({ status: 2 })
          this.showPermissionForm = false
          this.permissionNote = ''
        }
      })
  },
  savePresence({ status, studentId = null }) {
    let data = []
    const mark = this.permissionNote

    if (studentId === null) {
      this.studentPresence.forEach((id) => {
        data.push({ status, mark, id })
      })
    } else {
      data = [{ status, mark, id: studentId }]
    }

    const absen = JSON.stringify(data)
    const url = `${this.presenceApi}simpan-absen/${this.journalID}/${this.helper.activeDate}`

    axios
      .post(
        url,
        { absen },
        {
          headers: { Authorization: bearerToken },
          transformRequest: [(data) => createFormData(data)],
        },
      )
      .then(() => {
        // empty presence list
        this.studentPresence = []

        // reset all students checkbox
        if (this.checkAll) this.checkAll = false

        // reload presence data
        this.getPresence(this.presenceUrl)
      })
  },
  copyJournal() {
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('absensi_salin_jurnal_progress'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    axios
      .get(
        `${this.presenceApi}salin-jurnal/${this.scheduleID}/${this.helper.activeDate}`,
        {
          headers: { Authorization: bearerToken },
        },
      )
      .then((res) => {
        notifyProgress({ timeout })
        if (res.data.status === 'OK') {
          this.journalID = res.data.id
          this.salinJurnal = false
          this.getJournal(() => {
            notifyProgress({
              message: `${t('sukses')} ${res.data.msg}`,
              color: 'positive',
              icon: 'done',
              spinner: false,
            })
          })
        } else {
          notifyProgress({
            message: `Error! ${res.data.msg}`,
            color: 'negative',
            spinner: false,
          })
        }
      })
  },
  saveJournal() {
    const baseUrl = `${this.presenceApi}save/${this.scheduleID}/${this.helper.activeDate}`
    const includeHomework = this.helper.homework ? 'true' : 'false'
    const data = {
      description: this.journal.description,
      homework_title: this.journal.homework_title,
      homework_description: this.journal.homework_description,
      due_date: date.formatDate(this.journal.due_date, 'YYYY-MM-DD'),
      grade: this.classID,
      copyPresence: localStorage.getItem('copy_presence'),
    }

    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('absensi_jurnal_save_progress'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    axios
      .post(`${baseUrl}/${includeHomework}`, data, {
        headers: { Authorization: bearerToken },
        transformRequest: [
          (data) => {
            return createFormData(data)
          },
        ],
      })
      .then((res) => {
        notifyProgress({ timeout })
        if (res.data.code === '500') {
          this.error = res.data.msg
          notifyProgress({
            message: `Error! ${t('absensi_jurnal_error_save')}`,
            color: 'negative',
            spinner: false,
          })
        } else {
          this.error = {}
          notifyProgress({
            message: `${t('sukses')} ${t('absensi_jurnal_success_save')}`,
            color: 'positive',
            icon: 'done',
            spinner: false,
          })

          // reset everything
          this.showJournalForm = false
          this.journal = {
            description: '',
            homework_title: '',
            homework_description: '',
            due_date: '',
          }
          this.checkJournal()
        }
      })
  },
  checkJournal() {
    axios
      .get(
        `${this.presenceApi}cek-jurnal/${this.scheduleID}/${this.helper.activeDate}`,
        {
          headers: { Authorization: bearerToken },
        },
      )
      .then((response) => {
        const baseUrl = `${this.presenceApi}get-absen/${this.classID}/`
        let presenceUrl = `${baseUrl}null/null`

        const data = response.data

        if (data.status === 'true') {
          presenceUrl = `${baseUrl}${data.id}/${this.helper.activeDate}`
          this.presenceButtons = true
        } else {
          this.presenceButtons = false
        }

        this.journalStatus = data.status
        this.journalID = data.id

        // save presence URL
        this.presenceUrl = presenceUrl

        this.getPresence(presenceUrl)

        if (data.status === 'true') {
          this.salinJurnal = false
          this.getJournal()
        } else {
          this.salinJurnal = true
          this.helper.homework = false
          this.journal = {
            description: '',
            homework_title: '',
            homework_description: '',
            due_date: '',
          }
        }
      })
  },
  getJournal(copyJournalCallback = false) {
    axios
      .get(`${this.presenceApi}get-jurnal/${this.journalID}`, {
        headers: { Authorization: bearerToken },
      })
      .then((res) => {
        this.journal.description = res.data.journal.description
        if (res.data.homework !== null) {
          // toggle homework checkbox
          this.helper.homework = true

          const hw = res.data.homework
          this.journal.homework_title = hw.homework_title
          this.journal.homework_description = hw.homework_description
          this.journal.due_date = hw.due_date
        } else {
          // reset if it has previously filled
          this.helper.homework = false
          this.journal.homework_title = ''
          this.journal.homework_description = ''
          this.journal.due_date = ''
        }

        if (copyJournalCallback !== false) {
          copyJournalCallback()
        }
      })
  },
  getSchedules(grade) {
    axios
      .get(`${this.presenceApi}get-jadwal/${this.helper.activeDay}/${grade}`, {
        headers: { Authorization: bearerToken },
      })
      .then((response) => {
        this.schedule = response.data
        if (this.schedule.length > 0) {
          this.scheduleID = this.schedule[0].id
          this.showJournalBtn = true
          this.checkJournal()
        }
      })
  },

  // from Vuex mutations
  // ---------------------------------------------------
  checkHomeroomTeacher() {
    teacher
      .get('absensi/cek-walikelas', {
        headers: { Authorization: bearerToken },
      })
      .then(({ data }) => {
        if (data !== null) {
          this.isHomeroomTeacher = data.check
          if (data.check !== 0) {
            this.teacherOf = data.data.grade_id
          }
        }
      })
  },
  getClassName(id) {
    admin
      .get(`kelas/detail/${id}`, {
        headers: { Authorization: bearerToken },
      })
      .then((response) => {
        this.className = response.data.grade_name
      })
  },
  multiPresence(callback) {
    if (this.studentPresence.length > 0) {
      callback()
    } else {
      flashAlert(t('pilih_data'), 'negative')
    }
  },
  selectAll() {
    if (this.checkAll) {
      this.presenceList.forEach((item) => {
        this.studentPresence.push(item.id)
      })
    } else {
      this.studentPresence = []
    }
  },
  getPresence(url) {
    axios
      .get(url, {
        headers: { Authorization: bearerToken },
      })
      .then((response) => {
        this.presenceList = response.data
      })
  },
}
