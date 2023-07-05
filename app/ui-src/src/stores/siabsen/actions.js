import {
  bearerToken,
  siabsen,
  timeout,
  createFormData,
  t,
  conf,
  Cookies
} from '../../composables/common'

import { Notify, Dialog } from 'quasar'
import { usePagingStore as paging } from 'ss-paging-vue'

export default {
  getAttendance(agendaId) {
    paging().getData({
      token: bearerToken,
      lang: localStorage.getItem(conf.userLang),
      limit: 50,
      offset: this.current - 1,
      orderBy: 'none',
      searchBy: 'none',
      sort: 'none',
      search: '',
      url: `${conf.siabsenAPI}get-daftar-hadir/${agendaId}/`,
    })
  },
  getAllEvents() {
    siabsen.get(`get-kegiatan/${this.period}/1`, {
      headers: { Authorization: bearerToken }
    }).then(({ data }) => {
      this.allEvents = data
    })
  },
  getUserEvents() {
    siabsen.get(`get-kegiatan/${this.period}`, {
      headers: { Authorization: bearerToken }
    }).then(({ data }) => {
      this.userEvents = data
    })
  },
  getRequiredPresent(val) {
    this.requiredPresent = val
    this.getStaffPresence()
  },
  updatePresenceSchedule() {
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('siabsen_jadwal_progress'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    const data = Object.entries(this.scheduleDays).filter(key => key[1].value === true)
    const filtered = Object.fromEntries(data)
    const postData = {
      id: this.staffId,
      schedule: JSON.stringify(filtered)
    }

    siabsen.post('update-jadwal', postData, {
      headers: {
        Authorization: bearerToken
      },
      transformRequest: [data => createFormData(data)]
    }).then(({ data }) => {
      this.getStaffScheduleList()
      this.showScheduleForm = false
      notifyProgress({
        message: `${t('sukses')} ${t('siabsen_jadwal_success')}`,
        color: 'positive',
        icon: 'done',
        spinner: false,
        timeout
      })
    }).catch(error => {
      notifyProgress({
        message: `Error! ${t('siabsen_jadwal_error')} [${error}]`,
        color: 'negative',
        spinner: false,
        timeout: 8000
      })
    })
  },
  promptSync(id) {
    const dialog = Dialog.create({
      title: t('siabsen_sync_confirm'),
      message: t('siabsen_sync_confirm_msg'),
      cancel: {
        label: t('batal'),
        flat: true
      }
    }).onOk(() => {
      this.syncFromTeachingSchedule(id)
    })
  },
  syncFromTeachingSchedule(id) {
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('siabsen_sync_progress'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    siabsen.get(`sync-jadwal-mengajar/${id}`, {
      headers: {
        Authorization: bearerToken
      }
    }).then(({ data }) => {
      this.getStaffScheduleList()
      notifyProgress({
        message: `${t('sukses')} ${t('siabsen_sync_success')}`,
        color: 'positive',
        icon: 'done',
        spinner: false,
        timeout
      })
    }).catch(error => {
      notifyProgress({
        message: `Error! ${t('siabsen_sync_error')} [${error}]`,
        color: 'negative',
        spinner: false,
        timeout: 8000
      })
    })
  },
  getDetailSchedule({ schedule, name, id }) {
    this.staffName = name
    this.staffId = id
    for (let i in schedule) {
      this.scheduleDays[i] = {
        value: schedule[i]['value'] !== 'null' ? true : false,
        timein: schedule[i]['timein'],
        timeout: schedule[i]['timeout']
      }
    }

    this.showScheduleForm = true
  },
  getStaffScheduleList() {
    const limit = 25
    this.paging().rows = limit

    paging().getData({
      token: bearerToken,
      lang: localStorage.getItem(conf.userLang),
      limit,
      offset: this.current - 1,
      orderBy: 'staff_name',
      searchBy: 'staff_name',
      sort: 'ASC',
      search: '',
      url: `${conf.siabsenAPI}jadwal-absen-guru/`,
      autoReset: {
        active: true,
        timeout: 500
      },
    })
  },
  deletePermission() {
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('progress_hapus'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    siabsen.post('hapus-izin', { id: this.selectedPermission }, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    }).then(({ data }) => {
      if (data.status === 200) {
        notifyProgress({
          message: `${t('sukses')} ${t('siabsen_sukses_hapus_izin')}`,
          color: 'positive',
          icon: 'done',
          spinner: false,
          timeout
        })
      } else {
        notifyProgress({
          message: `Error! ${t('siabsen_gagal_hapus_izin')}`,
          color: 'negative',
          spinner: false,
          timeout: 7000
        })
      }

      this.getPermissions()
      this.closeDeleteConfirm()
    })
  },
  showDeleteConfirm(id) {
    this.selectedPermission = id
    this.deleteConfirm = true
    this.disableSaveButton = false
  },
  getPermissionNotif() {
    siabsen.get('get-notif-izin', {
      headers: {
        Authorization: bearerToken
      }
    }).then(({ data }) => {
      this.notifCounter = data.notif
    })
  },
  saveConfig() {
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('siabsen_config_progress'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    siabsen.post(`save-config`, this.presenceConfig, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(({ data }) => {
        if (data.code === '500') {
          this.configError = data.msg
          notifyProgress({
            message: `Error! ${t('siabsen_config_failed')}`,
            color: 'negative',
            spinner: false,
            timeout
          })
        } else {
          this.configError = {}
          notifyProgress({
            message: `${t('sukses')} ${t('siabsen_config_success')}`,
            color: 'positive',
            icon: 'done',
            spinner: false,
            timeout
          })
        }
      })
  },
  getAllStaffSummary({ start, end, type }) {
    this.spinner = true
    return new Promise((resolve, reject) => {
      paging().getData({
        token: bearerToken,
        lang: localStorage.getItem(conf.userLang),
        limit: 5,
        offset: this.current - 1,
        orderBy: 'staff_name',
        searchBy: 'staff_name',
        sort: 'ASC',
        search: '',
        url: `${conf.siabsenAPI}rekap-bulanan/${start}/${end}/${type}/`,
        autoReset: {
          active: true,
          timeout: 500
        },
      })

      setTimeout(() => {
        resolve()
      }, 500)

    })
    //this.spinner = false
  },
  getPermissionDetail(id) {
    siabsen.get(`get-detail-izin/${id}`, {
      headers: { Authorization: bearerToken }
    })
      .then(({ data }) => {
        this.permitDetail = data
        this.showPermitDetail = true
      })
  },
  setPermitStatus({ status, id }) {
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('siabsen_renew_izin'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    siabsen.post(`set-status-izin/${id}`, { status }, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(res => {
        this.getPermissions()
        this.getPermissionNotif()
        this.showPermitDetail = false
        notifyProgress({
          message: `${t('sukses')} ${t('siabsen_renew_izin_success')}`,
          color: 'positive',
          icon: 'done',
          spinner: false,
          timeout
        })
      })
      .catch(err => {
        notifyProgress({
          message: `Error! ${t('siabsen_renew_izin_failed')} [${err.message}]`,
          color: 'negative',
          spinner: false,
          timeout
        })
      })
  },
  getPermissions() {
    const limit = 25
    this.paging().rows = limit

    const withId = Cookies.get(conf.userType) === '1' ? 'false' : 'true'

    paging().getData({
      token: bearerToken,
      lang: localStorage.getItem(conf.userLang),
      limit,
      offset: this.current - 1,
      orderBy: 'permit_date',
      searchBy: 'staff_name',
      sort: 'DESC',
      search: '',
      url: `${conf.siabsenAPI}get-izin/${withId}/`,
      autoReset: {
        active: true,
        timeout: 500
      },
    })
  },
  sendPermitRequest(data) {
    this.disableSaveButton = true
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('siabsen_permit_progress'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    siabsen.post('kirim-izin', data, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(response => {
        this.disableSaveButton = false
        const res = response.data
        if (res.code === '500') {
          this.permitError = res.msg
          notifyProgress({
            message: `Error! ${t('siabsen_permit_error')}`,
            color: 'negative',
            spinner: false,
            timeout
          })
        } else {
          this.saveStatus = 200
          this.disableSaveButton = true
          this.getPermissions()

          // this.resetForm')
          this.showPermitForm = false
          notifyProgress({
            message: `${t('sukses')} ${t('siabsen_permit_success')}`,
            color: 'positive',
            icon: 'done',
            spinner: false,
            timeout
          })
        }
      })
  },
  getStaffPresence() {
    const limit = 25
    this.paging().rows = limit
    paging().getData({
      token: bearerToken,
      lang: localStorage.getItem(conf.userLang),
      limit,
      offset: this.current - 1,
      orderBy: 'staff_name',
      searchBy: 'staff_name',
      sort: 'ASC',
      search: '',
      url: `${conf.siabsenAPI}get-absensi-pegawai/${this.requiredPresent}/${this.activeDate}/`,
    })
  },
  pushPresence({ lat, long }) {
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('siabsen_progress_kirim'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    const presenceUrl = this.presenceType === 'agenda'
      ? `kirim-absen-agenda/${this.agendaId}`
      : `kirim-absen/${this.presenceType}`

    siabsen.post(`upload/${this.presenceType}`, { photo: this.base64String }, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => createFormData(data)]
    })
      .then(({ data }) => {
        const posts = {
          lat, long, photo: data.img
        }

        siabsen.post(presenceUrl, posts, {
          headers: { Authorization: bearerToken },
          transformRequest: [data => createFormData(data)]
        })
          .then(({ data }) => {
            if (data.code === 500) {
              notifyProgress({
                message: `Error! ${data.msg} [${data.reason}]`,
                color: 'negative',
                spinner: false,
                timeout: 5000,
              })
            } else {
              notifyProgress({
                message: `${t('sukses')} ${data.msg}`,
                color: 'positive',
                icon: 'done',
                spinner: false,
                timeout
              })

              this.presenceSuccess = true
              this.getTeacherStatus('masuk')
              this.getTeacherStatus('pulang')
              this.getUserEvents()
            }
          })
      })
      .catch(err => {
        notifyProgress({
          message: t('siabsen_error_network'),
          color: 'negative',
          spinner: false,
          timeout: 5000,
        })
      })

  },
  // -------------------- MUTATIONS --------------------------
  closeDeleteConfirm() {
    this.selectedPermission = null
    this.deleteConfirm = false
    this.disableSaveButton = true
  },
  getDetailPresence({ staffId, userId, dateStart, dateEnd }) {
    siabsen.get(`detail-absensi/${staffId}/${userId}/${dateStart}/${dateEnd}`, {
      headers: { Authorization: bearerToken }
    })
      .then(({ data }) => {
        this.presenceDetail = data
      })
  },
  getTeacherStatus(tag) {
    siabsen.get(`status-${tag}`, {
      headers: { Authorization: bearerToken }
    })
      .then(({ data }) => {
        const canAbsent = data.canAbsent === 1 ? true : false
        if (tag === 'masuk') {
          this.inStatus = data.status
          this.canInAbsent = canAbsent
          this.isLate = data.late === 1 ? true : false
          this.absenceIn = data.timeIn
        } else {
          this.outStatus = data.status
          this.canOutAbsent = canAbsent
          this.absenceOut = data.timeOut
        }
      })
  },
  getDetailConfig() {
    siabsen.get('get-detail-config', {
      headers: { Authorization: bearerToken }
    })
      .then(({ data }) => {
        this.presenceConfig = data
      })
  },
  getDailySchedule() {
    siabsen.get('get-jadwal-harian', {
      headers: { Authorization: bearerToken }
    })
      .then(({ data }) => {
        this.dailySchedule = data
      })
  },
  getConfig() {
    siabsen.get('get-config', {
      headers: { Authorization: bearerToken }
    })
      .then(({ data }) => {
        this.config = data
      })
  }
}