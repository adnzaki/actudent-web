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
  deleteEmployee() {
    let idString
    if (this.selectedEmployees.length > 1) {
      idString = this.selectedEmployees.join('&')
    } else {
      idString = this.selectedEmployees[0]
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
    admin.post(`${this.employeeApi}delete`, data, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(response => {
        notifyProgress({ timeout })
        this.helper.disableSaveButton = false
        this.deleteConfirm = false
        notifyProgress({
          message: t('staff_delete_success'),
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
      message: t('staff_save_progress'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    payload.data.featured_image = this.helper.filename

    admin.post(`${this.employeeApi}${url}`, payload.data, {
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
            message: `Error! ${t('staff_error_text')}`,
            color: 'negative',
            spinner: false
          })
        } else {
          this.saveStatus = 200
          this.resetForm()
          if (payload.edit) {
            this.showEditForm = false
            notifyProgress({
              message: `${t('sukses')} ${t('staff_update_success')}`,
              color: 'positive',
              icon: 'done',
              spinner: false
            })
          } else {
            this.showAddForm = false
            notifyProgress({
              message: `${t('sukses')} ${t('staff_insert_success')}`,
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
  getEmployee(afterSave = false) {
    const limit = 25
    paging().state.rows = limit

    paging().getData({
      token: bearerToken,
      lang: localStorage.getItem(conf.userLang),
      limit,
      offset: this.current - 1,
      orderBy: 'staff_name',
      searchBy: [
        'staff_nik', 'staff_name', 'staff_title'
      ],
      sort: 'ASC',
      search: '',
      url: `${conf.adminAPI}pegawai/get-pegawai/${this.employeeType}/`,
      autoReset: {
        active: true,
        timeout: 500
      },
    })
  },
  getEmployeeByType(model) {
    this.employeeType = model.value
    this.getEmployee()
  },
  getDetail(id) {
    this.error = {}
    this.showEditForm = true
    admin.get(`${this.employeeApi}detail/${id}`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        this.detail = response.data
        this.helper.filename = response.data.staff_photo
      })
  },
  showDeleteConfirm(payload) {
    this.selectedEmployees = []
    this.selectedEmployees.push(`${payload.staff}-${payload.user}`)
    this.deleteConfirm = true
  },
  multipleDeleteConfirm() {
    if (this.selectedEmployees.length > 0) {
      this.deleteConfirm = true
    } else {
      flashAlert(t('pilih_data_dulu'), 'negative')
    }
  },
  closeDeleteConfirm() {
    this.selectedEmployees = []
    this.deleteConfirm = false
    this.checkAll = false
  },
  uploadImage(val) {
    this.helper.disableSaveButton = true
    const formData = new FormData()
    formData.append('staff_photo', val)
    admin.post(`${this.employeeApi}validate-file`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
        Authorization: bearerToken
      }
    })
      .then(response => {
        if (response.data.msg === 'OK') {
          this.error.featured_image = ''
          this.error.staff_photo = ''
          this.helper.disableSaveButton = false
          this.helper.validImage = true
          this.helper.filename = response.data.img
        } else {
          this.error = response.data
          this.helper.disableSaveButton = true
        }
      })
      .catch(error => console.error(error))
  },
  selectAll() {
    if (this.checkAll) {
      paging().state.data.forEach(item => {
        this.selectedEmployees.push(`${item.staff_id}-${item.user_id}`)
      })
    } else {
      this.selectedEmployees = []
    }
  }
}
