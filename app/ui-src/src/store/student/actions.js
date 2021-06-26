import { 
  Cookies,
  conf,
  bearerToken,
  admin,
  timeout,
  errorNotif,
  createFormData,
  pengguna
} from '../../composables/common'

import { Notify } from 'quasar'

const actions = {
  getStudents({ state, dispatch }) {
    // mutate paging.rows in order to affect
    // model-value on QSelect
    const limit = 25
    state.paging.rows = limit

    dispatch('getData', {
      token: bearerToken,
      lang: pengguna.value.user_language,
      limit,
      offset: 0,
      orderBy: 'student_name',
      searchBy: [
        'student_nis', 'student_name'
      ],
      sort: 'ASC',
      where: null,
      search: '',
      url: `${conf.adminAPI}siswa/get-siswa/`,
      autoReset: {
        active: true,
        timeout: 500
      },
    })
  },
  getStudentsByClass({ state, dispatch }, model) {
    state.paging.whereClause = model.value
    dispatch('runPaging')
  },
  onPaginationUpdate({ state, dispatch }) {
    if(Cookies.has(conf.cookieName)) {
      dispatch('nav', state.current - 1)
    } else {
      errorNotif()
    }
  },
}

export default actions
