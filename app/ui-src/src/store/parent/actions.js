import { 
  Cookies,
  conf,
  bearerToken,
  admin,
  timeout,
  errorNotif,
  createFormData,
  pengguna,
  t
} from '../../composables/common'

import { Notify } from 'quasar'

export default {
  getOrtu({ state, dispatch }) {
    const limit = 25
    state.paging.rows = limit

    dispatch('getData', {
      token: bearerToken,
      lang: localStorage.getItem(conf.userLang),
      limit,
      offset: state.current - 1,
      orderBy: 'parent_father_name',
      searchBy: [
        'parent_family_card', 'parent_father_name',
        'parent_mother_name', 'parent_phone_number'
      ],
      sort: 'ASC',
      search: '',
      url: `${conf.adminAPI}orang-tua/get-ortu/`,
      autoReset: {
        active: true,
        timeout: 500
      },
    })
  },

  // payload: { data, lang, edit, id }
  save({ state, dispatch }, payload) {
    let url
    payload.edit ? url = `save/${payload.id}` : url = 'save'
    state.helper.disableSaveButton = true
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('ortu_save_progress'),
      color: 'info',
      position: 'center',
      timeout,
    })

    admin.post(`${state.parentApi}${url}`, payload.data, {
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
            message: `Error! ${t('ortu_error_text')}`,
            color: 'negative',
            spinner: false
          })
        } else {
          state.saveStatus = 200
          dispatch('resetForm')
          if(payload.edit) {
            state.showEditForm = false
            notifyProgress({
              message: `${t('sukses')} ${t('ortu_update_success')}`,
              color: 'positive',
              icon: 'done',
              spinner: false
            })
          } else {
            state.showAddForm = false
            notifyProgress({
              message: `${t('sukses')} ${t('ortu_insert_success')}`,
              color: 'positive',
              icon: 'done',
              spinner: false
            })
          }
        }
      })
  },
  deleteParent({ state, dispatch }) {
    let idString
    if(state.selectedParents.length > 1) {
        idString = state.selectedParents.join('&')
    } else {
        idString = state.selectedParents[0]
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
    admin.post(`${state.parentApi}delete`, data, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(response => {
        state.helper.disableSaveButton = false
        state.deleteConfirm = false
        notifyProgress({
          message: t('ortu_delete_success'),
          color: 'positive',
          icon: 'done',
          spinner: false
        })

        // refresh data
        dispatch('resetForm')
      })
  },
  resetForm({ state, dispatch }) {
    state.error = {}
    state.current = 1
    dispatch('getOrtu')
  }
}
