import { 
  bearerToken,
  siabsen,
  timeout,
  createFormData,
  t,
  conf,
  Cookies
} from '../../composables/common'

import { date } from 'quasar'

import { Notify, Dialog } from 'quasar'

export default {
  getRequiredPresent({ state, dispatch }, val) {
    state.requiredPresent = val
    dispatch('getStaffPresence')
  },
  updatePresenceSchedule({ state, dispatch }) {
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('siabsen_jadwal_progress'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    const data = Object.entries(state.scheduleDays).filter(key => key[1].value === true)
    const filtered = Object.fromEntries(data)
    const postData = {
      id: state.staffId,
      schedule: JSON.stringify(filtered)
    }

    siabsen.post('update-jadwal', postData, {
      headers: {
        Authorization: bearerToken
      },
      transformRequest: [data => createFormData(data)]
    }).then(({ data }) => {
      dispatch('getStaffScheduleList')
      state.showScheduleForm = false
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
  promptSync({ dispatch }, id) {
    const dialog = Dialog.create({
      title: t('siabsen_sync_confirm'),
      message: t('siabsen_sync_confirm_msg'),
      cancel: {
        label: t('batal'),
        flat: true
      }      
    }).onOk(() => {
      dispatch('syncFromTeachingSchedule', id)
    })
  },
  syncFromTeachingSchedule({ dispatch }, id) {
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
      dispatch('getStaffScheduleList')
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
  getDetailSchedule({ state, dispatch }, { schedule, name, id }) {
    state.staffName = name
    state.staffId = id
    for(let i in schedule) {
      state.scheduleDays[i] = {
        value: schedule[i]['value'] !== 'null' ? true : false,
        timein: schedule[i]['timein'],
        timeout: schedule[i]['timeout']
      }
    }

    state.showScheduleForm = true
  },
  getStaffScheduleList({ state, dispatch }) {
    const limit = 25
    state.paging.rows = limit

    dispatch('getData', {
      token: bearerToken,
      lang: localStorage.getItem(conf.userLang),
      limit,
      offset: state.current - 1,
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
  deletePermission({ state, commit, dispatch }) {
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('progress_hapus'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    siabsen.post('hapus-izin', { id: state.selectedPermission }, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    }).then(({ data }) => {
      if(data.status === 200) {
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

      dispatch('getPermissions')
      commit('closeDeleteConfirm')
    })
  },
  showDeleteConfirm({ state }, id) {
    state.selectedPermission = id
    state.deleteConfirm = true
    state.disableSaveButton = false
  },
  getPermissionNotif({ state }) {
    siabsen.get('get-notif-izin', {
      headers: {
        Authorization: bearerToken
      }
    }).then(({ data }) => {
      state.notifCounter = data.notif
    })
  },
  saveConfig({ state }) {
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('siabsen_config_progress'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    siabsen.post(`save-config`, state.presenceConfig, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(( { data }) => {
        if(data.code === '500') {
          state.configError = data.msg
          notifyProgress({
            message: `Error! ${t('siabsen_config_failed')}`,
            color: 'negative',
            spinner: false,
            timeout
          })
        } else {
          state.configError = {}
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
  getAllStaffSummary({ state, dispatch }, period) {
    dispatch('getData', {
      token: bearerToken,
      lang: localStorage.getItem(conf.userLang),
      limit: 25,
      offset: state.current - 1,
      orderBy: 'staff_name',
      searchBy: 'staff_name',
      sort: 'ASC',
      search: '',
      url: `${conf.siabsenAPI}rekap-bulanan/${period}/`,
      autoReset: {
        active: true,
        timeout: 500
      },
    })
  },
  getPermissionDetail({ state, dispatch }, id) {
    siabsen.get(`get-detail-izin/${id}`, {
      headers: { Authorization: bearerToken }
    })
      .then(({ data }) => {
        state.permitDetail = data
        state.showPermitDetail = true
      }) 
  },
  setPermitStatus({ state, dispatch }, { status, id }) {
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
        dispatch('getPermissions')
        dispatch('getPermissionNotif')
        state.showPermitDetail = false
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
  getPermissions({ state, dispatch }) {
    const limit = 25
    state.paging.rows = limit

    const withId = Cookies.get(conf.userType) === '1' ? 'false' : 'true'

    dispatch('getData', {
      token: bearerToken,
      lang: localStorage.getItem(conf.userLang),
      limit,
      offset: state.current - 1,
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
  sendPermitRequest({ state, dispatch }, data) {
    state.disableSaveButton = true
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
        state.disableSaveButton = false
        const res = response.data
        if(res.code === '500') {
          state.permitError = res.msg
          notifyProgress({
            message: `Error! ${t('siabsen_permit_error')}`,
            color: 'negative',
            spinner: false,
            timeout
          })
        } else {
          state.saveStatus = 200
          state.disableSaveButton = true
          dispatch('getPermissions')

          // dispatch('resetForm')
          state.showPermitForm = false
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
  getStaffPresence({ state, dispatch }) {
    const limit = 25
    state.paging.rows = limit
    dispatch('getData', {
      token: bearerToken,
      lang: localStorage.getItem(conf.userLang),
      limit,
      offset: state.current - 1,
      orderBy: 'staff_name',
      searchBy: 'staff_name',
      sort: 'ASC',
      search: '',
      url: `${conf.siabsenAPI}get-absensi-pegawai/${state.requiredPresent}/${state.activeDate}/`,
    })
  },
  pushPresence({ state, commit }, { lat, long }) {
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('siabsen_progress_kirim'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    siabsen.post(`upload/${state.presenceType}`, { photo: state.base64String }, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => createFormData(data)]
    })
      .then(({ data }) => {
        const posts = {
          lat, long, photo: data.img
        }

        siabsen.post(`kirim-absen/${state.presenceType}`, posts, {
          headers: { Authorization: bearerToken },
          transformRequest: [data => createFormData(data)]
        })
          .then(({ data }) => {
            if(data.code === 500) {
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
    
              state.presenceSuccess = true
              commit('getTeacherStatus', 'masuk')
              commit('getTeacherStatus', 'pulang')
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

  }
}