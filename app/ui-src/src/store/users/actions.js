import { 
  conf,
  bearerToken,
  admin,
  timeout,
  createFormData,
  t
} from '../../composables/common'

import { Notify } from 'quasar'

export default {
  save({ state, dispatch }, payload) {
    state.helper.disableSaveButton = true
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('user_save_progress'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    admin.post(`${state.userApi}save/${payload.id}`, payload.data, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(({ data }) => {
        notifyProgress({ timeout })
        state.helper.disableSaveButton = false
        
        if(data.code === '500') {
          state.error = data.msg
          notifyProgress({
            message: `Error! ${t('user_error_text')}`,
            color: 'negative',
            spinner: false
          })
        } else {
          state.saveStatus = 200
          dispatch('resetForm')
          state.showForm = false
          notifyProgress({
            message: `${t('sukses')} ${t('user_update_success')}`,
            color: 'positive',
            icon: 'done',
            spinner: false
          })
        }
      })
  },
  resetForm({ state, dispatch }) {
    state.error = {}
    state.current = 1
    dispatch('getUsers', true)
  },
  getUserDetail({ state }, id) {
    state.error = {}
    state.showForm = true
    admin.get(`${state.userApi}detail/${id}`, {
      headers: { Authorization: bearerToken }
    })
      .then(({ data }) => {
        state.detail = data
      })
  },
  getUsers({ state, dispatch }, afterSave = false) {
    const limit = 25
    state.paging.rows = limit

    dispatch('getData', {
      token: bearerToken,
      lang: localStorage.getItem(conf.userLang),
      limit: afterSave ? state.paging.limit : limit,
      offset: state.current - 1,
      orderBy: 'user_name',
      searchBy: [
        'user_name', 'user_email'
      ],
      sort: 'ASC',
      where: null,
      search: '',
      url: `${conf.adminAPI}pengguna/get-pengguna/`,
      autoReset: {
        active: true,
        timeout: 500
      },
    })
  },
  getUserByType({ state, dispatch }, model) {
    state.paging.whereClause = model.value
    dispatch('runPaging')
  },
}