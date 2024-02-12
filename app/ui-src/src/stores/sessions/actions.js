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
  deleteSession() {
    // show notify
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('deleting_session'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    const data = { id: this.selectedSession }
    admin
      .post(`session/delete`, data, {
        headers: { Authorization: bearerToken },
        transformRequest: [
          (data) => {
            return createFormData(data)
          },
        ],
      })
      .then(() => {
        this.helper.disableSaveButton = false
        this.deleteConfirm = false
        notifyProgress({
          message: t('deleted_session'),
          color: 'positive',
          icon: 'done',
          spinner: false,
          timeout,
        })

        // refresh data
        this.getActiveSessions()
      })
  },
  showDeleteConfirm(id) {
    this.selectedSession = id
    this.deleteConfirm = true
  },
  closeDeleteConfirm(id) {
    this.selectedSession = null
    this.deleteConfirm = false
  },
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
