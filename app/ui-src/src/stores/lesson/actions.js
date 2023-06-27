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
  flashAlert
} from '../../composables/common'

import { Notify } from 'quasar'
import { usePagingStore as paging } from 'ss-paging-vue'

export default {
  deleteLesson() {
    let idString
    if (this.selectedLessons.length > 1) {
      idString = this.selectedLessons.join('-')
    } else {
      idString = this.selectedLessons[0]
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
    admin.post(`${this.lessonApi}delete`, data, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(() => {
        notifyProgress({ timeout })
        this.helper.disableSaveButton = false
        this.deleteConfirm = false
        notifyProgress({
          message: t('mapel_delete_success'),
          color: 'positive',
          icon: 'done',
          spinner: false
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
      message: t('mapel_save_progress'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    admin.post(`${this.lessonApi}${url}`, payload.data, {
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
            message: `Error! ${t('mapel_error_text')}`,
            color: 'negative',
            spinner: false
          })
        } else {
          this.saveStatus = 200

          this.resetForm()
          if (payload.edit) {
            this.showEditForm = false
            notifyProgress({
              message: `${t('sukses')} ${t('mapel_update_success')}`,
              color: 'positive',
              icon: 'done',
              spinner: false
            })
          } else {
            this.showAddForm = false
            notifyProgress({
              message: `${t('sukses')} ${t('mapel_insert_success')}`,
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
  getLessons(afterSave = false) {
    const limit = 25
    paging().state.rows = limit

    paging().getData({
      token: bearerToken,
      lang: localStorage.getItem(conf.userLang),
      limit,
      offset: this.current - 1,
      orderBy: 'lesson_name',
      searchBy: ['lesson_code', 'lesson_name'],
      sort: 'ASC',
      search: '',
      url: `${conf.adminAPI}mapel/get-mapel/`,
      autoReset: {
        active: true,
        timeout: 500
      },
    })
  },
  getDetail(id) {
    this.error = {}
    this.showEditForm = true
    admin.get(`${this.lessonApi}detail/${id}`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        this.detail = response.data
      })
  },
  closeDeleteConfirm() {
    this.selectedLessons = []
    this.deleteConfirm = false
    this.checkAll = false
  },
  showDeleteConfirm(id) {
    this.selectedLessons = []
    this.selectedLessons.push(id)
    this.deleteConfirm = true
  },
  selectAll() {
    if (this.checkAll) {
      paging().state.data.forEach(item => {
        this.selectedLessons.push(item.lesson_id)
      })
    } else {
      this.selectedLessons = []
    }
  },
  multipleDeleteConfirm() {
    if (this.selectedLessons.length > 0) {
      this.deleteConfirm = true
    } else {
      flashAlert(t('pilih_data_dulu'), 'negative')
    }
  },
}