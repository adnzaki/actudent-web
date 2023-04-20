import {
  conf,
  bearerToken,
  admin,
  timeout,
  createFormData,
  t
} from '../../composables/common'

import { Notify } from 'quasar'
import { usePagingStore as paging } from 'ss-paging-vue'

export default {
  deactivate() {
    this.helper.disableSaveButton = true
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('user_deactivate_progress'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    admin.get(`${this.userApi}deactivate/${this.selectedUser}`, {
      headers: { Authorization: bearerToken },
    }).then(({ data }) => {
      this.helper.disableSaveButton = false

      notifyProgress({ timeout })
      this.resetForm()
      this.closeDeleteConfirm()

      notifyProgress({
        message: `${t('sukses')} ${t('user_deactivate_success')}`,
        color: 'positive',
        icon: 'done',
        spinner: false
      })
    })
  },
  save(payload) {
    this.helper.disableSaveButton = true
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('user_save_progress'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    admin.post(`${this.userApi}save/${payload.id}`, payload.data, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(({ data }) => {
        notifyProgress({ timeout })
        this.helper.disableSaveButton = false

        if (data.code === '500') {
          this.error = data.msg
          notifyProgress({
            message: `Error! ${t('user_error_text')}`,
            color: 'negative',
            spinner: false
          })
        } else {
          this.saveStatus = 200
          this.resetForm()
          this.showForm = false
          notifyProgress({
            message: `${t('sukses')} ${t('user_update_success')}`,
            color: 'positive',
            icon: 'done',
            spinner: false
          })
        }
      })
  },
  resetForm() {
    this.error = {}
    paging().reloadData()
  },
  getUserDetail(id) {
    this.error = {}
    this.showForm = true
    admin.get(`${this.userApi}detail/${id}`, {
      headers: { Authorization: bearerToken }
    })
      .then(({ data }) => {
        this.detail = data
      })
  },
  getUsers() {
    const limit = 25
    paging().state.rows = limit

    paging().getData({
      token: bearerToken,
      lang: localStorage.getItem(conf.userLang),
      limit,
      offset: this.current - 1,
      orderBy: 'user_name',
      searchBy: [
        'user_name', 'user_email'
      ],
      sort: 'ASC',
      search: '',
      url: `${conf.adminAPI}pengguna/get-pengguna/${this.userType}/`,
      autoReset: {
        active: true,
        timeout: 500
      },
    })
  },
  getUserByType(model) {
    this.userType = model.value
    this.getUsers()
  },

  // From Vuex mutations
  // ------------------------------------------------------------------
  showDeactivateConfirm(id) {
    this.selectedUser = id
    this.deleteConfirm = true
  },
  closeDeleteConfirm() {
    this.selectedUser = null
    this.deleteConfirm = false
  },
}