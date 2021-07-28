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

const actions = {
  getEmployee({ dispatch }) {
    dispatch('getData', {
      token: bearerToken,
      lang: pengguna.value.user_language,
      limit: 10,
      offset: 0,
      orderBy: 'staff_name',
      searchBy: [
        'staff_nik', 'staff_name', 'staff_title'
      ],
      sort: 'ASC',
      where: null,
      search: '',
      url: `${conf.adminAPI}pegawai/get-pegawai/`,
      autoReset: {
        active: true,
        timeout: 500
      },
    })
  },
  getEmployeeByType({ state, dispatch }, model) {
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
