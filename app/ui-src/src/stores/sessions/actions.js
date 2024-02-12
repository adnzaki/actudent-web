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
  flashAlert,
} from '../../composables/common'

import { Notify, Dialog } from 'quasar'
import { usePagingStore as paging } from 'ss-paging-vue'

export default {
  getActiveSessions() {
    admin
      .get('session/active', { headers: { Authorization: bearerToken } })
      .then(({ data }) => {
        if (data.msg === 'OK') {
          this.sessions = data.result
        } else {
          this.sessions = null
        }
      })
  },
  getHistory() {
    const limit = 5
    paging().state.rows = limit
    paging().getData({
      token: bearerToken,
      lang: localStorage.getItem(conf.userLang),
      limit,
      offset: this.current - 1,
      orderBy: 'x',
      searchBy: 'x',
      sort: 'x',
      url: `${conf.adminAPI}session/logins/`,
      autoReset: {
        active: true,
        timeout: 500,
      },
    })
  },
}
