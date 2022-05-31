import { 
  bearerToken,
  siabsen,
  timeout,
  createFormData,
  t,
} from '../../composables/common'

import { date } from 'quasar'

import { Notify } from 'quasar'

export default {
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
              commit('getTeacherStatus', state.presenceType)
            }
          })
      })
        .catch(err => err)

  }
}