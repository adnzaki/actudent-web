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

import { Notify } from 'quasar'

export default {
  saveConfig({ state, commit }) {
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
      url: `${conf.siabsenAPI}get-absensi-pegawai/${state.activeDate}/`,
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