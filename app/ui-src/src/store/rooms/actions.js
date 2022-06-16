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
  deleteRoom({ state, dispatch }) {
    let idString
    if(state.selectedRooms.length > 1) {
        idString = state.selectedRooms.join('-')
    } else {
        idString = state.selectedRooms[0]
    }

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
    admin.post(`${state.roomApi}delete`, data, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(() => {
        state.helper.disableSaveButton = false
        state.deleteConfirm = false
        notifyProgress({
          message: t('ruang_delete_success'),
          color: 'positive',
          icon: 'done',
          spinner: false
        })

        // refresh data
        dispatch('resetForm')
      })
  },
  save({ state, dispatch }, payload) {
    let url
    payload.edit ? url = `save/${payload.id}` : url = 'save'
    state.helper.disableSaveButton = true
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('ruang_save_progress'),
      color: 'info',
      position: 'center',
      timeout,
    })

    admin.post(`${state.roomApi}${url}`, payload.data, {
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
            message: `Error! ${t('ruang_error_text')}`,
            color: 'negative',
            spinner: false
          })
        } else {
          state.saveStatus = 200

          dispatch('resetForm')
          if(payload.edit) {
            state.showEditForm = false
            notifyProgress({
              message: `${t('sukses')} ${t('ruang_update_success')}`,
              color: 'positive',
              icon: 'done',
              spinner: false
            })
          } else {
            state.showAddForm = false
            notifyProgress({
              message: `${t('sukses')} ${t('ruang_insert_success')}`,
              color: 'positive',
              icon: 'done',
              spinner: false
            })
          }
        }
      })
  },
  resetForm({ state, dispatch }) {
    state.error = {}
    state.current = 1
    dispatch('getRooms', true)
  },
  getRooms({ state, dispatch }, afterSave = false) {
    const limit = 25
    state.paging.rows = limit

    dispatch('getData', {
      token: bearerToken,
      lang: localStorage.getItem(conf.userLang),
      limit: afterSave ? state.paging.limit : limit,
      offset: state.current - 1,
      orderBy: 'room_name',
      searchBy: ['room_code', 'room_name'],
      sort: 'ASC',
      search: '',
      url: `${conf.adminAPI}ruang/get-ruang/`,
      autoReset: {
        active: true,
        timeout: 500
      },
    })
  },
}