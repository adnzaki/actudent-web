import { 
  bearerToken,
  siabsen,
  timeout,
  createFormData,
  t,
  conf,
} from '../../composables/common'

import { date } from 'quasar'

import { Notify } from 'quasar'

export default {
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