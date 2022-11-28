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