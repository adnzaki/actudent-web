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
import { usePagingStore as paging } from 'ss-paging-vue'

export default {
  deleteRoom() {
    let idString
    if (this.selectedRooms.length > 1) {
      idString = this.selectedRooms.join('-')
    } else {
      idString = this.selectedRooms[0]
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
    admin.post(`${this.roomApi}delete`, data, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(() => {
        this.helper.disableSaveButton = false
        this.deleteConfirm = false
        notifyProgress({
          message: t('ruang_delete_success'),
          color: 'positive',
          icon: 'done',
          spinner: false,
          timeout
        })

        // refresh data
        this.resetForm()
      })
  },
  save(payload) {
    let url
    payload.edit ? url = `save/${payload.id}` : url = 'save'
    this.helper.disableSaveButton = true
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('ruang_save_progress'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    admin.post(`${this.roomApi}${url}`, payload.data, {
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
            message: `Error! ${t('ruang_error_text')}`,
            color: 'negative',
            spinner: false
          })
        } else {
          this.saveStatus = 200

          this.resetForm()
          if (payload.edit) {
            this.showEditForm = false
            notifyProgress({
              message: `${t('sukses')} ${t('ruang_update_success')}`,
              color: 'positive',
              icon: 'done',
              spinner: false
            })
          } else {
            this.showAddForm = false
            notifyProgress({
              message: `${t('sukses')} ${t('ruang_insert_success')}`,
              color: 'positive',
              icon: 'done',
              spinner: false
            })
          }
        }
      })
  },
  resetForm() {
    this.error = {}
    this.current = 1
    paging().reloadData()
  },
  getRooms(afterSave = false) {
    const limit = 25
    paging().state.rows = limit

    paging().getData({
      token: bearerToken,
      lang: localStorage.getItem(conf.userLang),
      limit,
      offset: this.current - 1,
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
  getDetail(id) {
    this.error = {}
    this.showEditForm = true
    admin.get(`${this.roomApi}detail/${id}`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        this.detail = response.data
      })
  },
  closeDeleteConfirm() {
    this.selectedRooms = []
    this.deleteConfirm = false
    this.checkAll = false
  },
  showDeleteConfirm(id) {
    this.selectedRooms = []
    this.selectedRooms.push(id)
    this.deleteConfirm = true
  },
  selectAll() {
    if (this.checkAll) {
      this.paging().data.forEach(item => {
        this.selectedRooms.push(item.room_id)
      })
    } else {
      this.selectedRooms = []
    }
  },
  multipleDeleteConfirm() {
    if (this.selectedRooms.length > 0) {
      this.deleteConfirm = true
    } else {
      flashAlert(t('pilih_data_dulu'), 'negative')
    }
  },
}