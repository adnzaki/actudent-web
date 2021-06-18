import { 
  Cookies,
  conf,
  bearerToken,
  admin,
  timeout,
  errorNotif,
  createFormData
} from '../../composables/common'

import { Notify } from 'quasar'

const actions = {
  getOrtu({ state, dispatch }) {
    dispatch('getData', {
      token: bearerToken,
      lang: 'indonesia',
      limit: 10,
      offset: 0,
      orderBy: 'parent_father_name',
      searchBy: [
        'parent_family_card', 'parent_father_name',
        'parent_mother_name', 'parent_phone_number'
      ],
      sort: 'ASC',
      search: '',
      url: `${state.parentURL}get-ortu/`,
      autoReset: {
        active: true,
        timeout: 500
      },
    })
  },
  onPaginationUpdate({ state, dispatch }) {
    if(Cookies.has(conf.cookieName)) {
      dispatch('nav', state.current - 1)
    } else {
      errorNotif()
    }
  },

  // payload: { data, lang, edit, id }
  save({ state, dispatch }, payload) {
    let url
    payload.edit ? url = `save/${payload.id}` : url = 'save'
    state.helper.disableSaveButton = true
    const notifyProgress = Notify.create({
      group: false,
      message: payload.lang.ortu_save_progress,
      color: 'info',
      position: 'center',
      timeout,
      actions: [ { label: 'X' , color: 'white' } ]
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
            message: `Error! ${payload.lang.ortu_error_text}`,
            color: 'negative',
          })
        } else {
          state.saveStatus = 200
          dispatch('resetForm')
          if(payload.edit) {
            state.showEditForm = false
            notifyProgress({
              message: `${payload.lang.sukses} ${payload.lang.ortu_update_success}`,
              color: 'positive',
            })
          } else {
            state.showAddForm = false
            notifyProgress({
              message: `${payload.lang.sukses} ${payload.lang.ortu_insert_success}`,
              color: 'positive',
            })
          }
        }
      })
  },
  resetForm({ state, dispatch }) {
    state.error = {}
    dispatch('getOrtu')
  }
}

export default actions
