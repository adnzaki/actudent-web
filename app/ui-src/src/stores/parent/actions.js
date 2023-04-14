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

import { usePagingStore as paging } from 'ss-paging-vue'
import { Notify } from 'quasar'

export default {
  getOrtu(afterSave = false) {
    const limit = 25
    paging().state.rows = limit

    paging().getData({
      token: bearerToken,
      lang: localStorage.getItem(conf.userLang),
      limit,
      offset: this.current - 1,
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
  save(payload) {
    let url
    payload.edit ? url = `save/${payload.id}` : url = 'save'
    this.helper.disableSaveButton = true
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('ortu_save_progress'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    admin.post(`${this.parentApi}${url}`, payload.data, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(response => {
        notifyProgress({ timeout })
        this.helper.disableSaveButton = false
        const res = response.data
        if (res.code === '500') {
          this.error = res.msg
          notifyProgress({
            message: `Error! ${t('ortu_error_text')}`,
            color: 'negative',
            spinner: false
          })
        } else {
          this.saveStatus = 200
          this.resetForm()
          if (payload.edit) {
            this.showEditForm = false
            notifyProgress({
              message: `${t('sukses')} ${t('ortu_update_success')}`,
              color: 'positive',
              icon: 'done',
              spinner: false
            })
          } else {
            this.showAddForm = false
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
  deleteParent() {
    let idString
    if (this.selectedParents.length > 1) {
      idString = this.selectedParents.join('&')
    } else {
      idString = this.selectedParents[0]
    }

    // show notify
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('progress_hapus'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    const data = { id: idString }
    admin.post(`${this.parentApi}delete`, data, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(response => {
        this.helper.disableSaveButton = false
        this.deleteConfirm = false
        notifyProgress({
          message: t('ortu_delete_success'),
          color: 'positive',
          icon: 'done',
          spinner: false,
          timeout
        })

        // refresh data
        this.resetForm()
      })
  },
  resetForm() {
    this.error = {}
    this.current = 1
    paging().reloadData()
  },
  // -------------- Converted Mutations -------------- 
  getDetail(id) {
    this.error = {}
    this.showEditForm = true
    admin.get(`${this.parentApi}detail/${id}`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        this.detail = response.data.parent
        this.children = response.data.children
      })
  },
  multipleDeleteConfirm() {
    if (this.selectedParents.length > 0) {
      this.deleteConfirm = true
    } else {
      flashAlert(t('pilih_data_dulu'), 'negative')
    }
  },
  showDeleteConfirm(id) {
    this.selectedParents = []
    this.selectedParents.push(id)
    this.deleteConfirm = true
  },
  closeDeleteConfirm() {
    this.selectedParents = []
    this.deleteConfirm = false
    this.checkAll = false
  },
  selectAll() {
    if (this.checkAll) {
      paging().state.data.forEach(item => {
        this.selectedParents.push(`${item.parent_id}-${item.user_id}`)
      })
    } else {
      this.selectedParents = []
    }
  }
}
