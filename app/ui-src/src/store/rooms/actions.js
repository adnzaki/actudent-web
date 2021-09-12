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

const actions = {
  getRooms({ dispatch }) {
    dispatch('getData', {
      token: bearerToken,
      lang: Cookies.get(conf.userLang),
      limit: 10,
      offset: 0,
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

export default actions