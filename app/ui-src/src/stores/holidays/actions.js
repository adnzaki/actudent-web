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
  phpTimestamp,
} from '../../composables/common'

import { Notify } from 'quasar'
import { usePagingStore as paging } from 'ss-paging-vue'

export default {
  deleteHoliday() {
    let idString
    if (this.selectedDays.length > 1) {
      idString = this.selectedDays.join('-')
    } else {
      idString = this.selectedDays[0]
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
    admin
      .post(`${this.baseUrl}delete`, data, {
        headers: { Authorization: bearerToken },
        transformRequest: [
          (data) => {
            return createFormData(data)
          },
        ],
      })
      .then(() => {
        this.disableSaveButton = false
        this.deleteConfirm = false
        notifyProgress({
          message: t('libur_delete_success'),
          color: 'positive',
          icon: 'done',
          spinner: false,
          timeout,
        })

        // refresh data
        this.resetForm()
      })
  },
  save() {
    let url
    this.isEditForm ? (url = `save/${this.holidayId}`) : (url = 'save')
    this.disableSaveButton = true
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('libur_save_progress'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    const data = {
      holiday_title: this.postData.holiday_title,
      start_date: phpTimestamp(this.postData.start_date),
      end_date: phpTimestamp(this.postData.end_date),
    }

    admin
      .post(`${this.baseUrl}${url}`, data, {
        headers: { Authorization: bearerToken },
        transformRequest: [
          (data) => {
            return createFormData(data)
          },
        ],
      })
      .then((response) => {
        notifyProgress({ timeout })
        this.disableSaveButton = false
        const res = response.data
        if (res.code === '500') {
          this.error = res.msg
          notifyProgress({
            message: `Error! ${t('libur_error_text')}`,
            color: 'negative',
            spinner: false,
          })
        } else {
          this.saveStatus = 200

          this.resetForm()
          if (this.holidayId !== null) {
            notifyProgress({
              message: `${t('sukses')} ${t('libur_update_success')}`,
              color: 'positive',
              icon: 'done',
              spinner: false,
            })

            // here we can reset holidayId
            this.holidayId = null

            this.isEditForm = false
          } else {
            notifyProgress({
              message: `${t('sukses')} ${t('libur_insert_success')}`,
              color: 'positive',
              icon: 'done',
              spinner: false,
            })
          }

          this.showForm = false
        }
      })
  },
  resetForm() {
    this.error = {}
    this.current = 1
    this.isEditForm = false

    // reset form
    this.postData = {
      holiday_title: '',
      start_date: '',
      end_date: '',
    }

    // reload data
    paging().reloadData()
  },
  getHolidays() {
    const limit = 10
    paging().state.rows = limit

    paging().getData({
      token: bearerToken,
      lang: localStorage.getItem(conf.userLang),
      limit,
      offset: this.current - 1,
      orderBy: 'start_date',
      searchBy: ['holiday_title'],
      sort: 'DESC',
      search: '',
      url: `${conf.adminAPI}libur/get-data/`,
      autoReset: {
        active: true,
        timeout: 500,
      },
    })
  },
  getDetail(id) {
    this.error = {}
    admin
      .get(`${this.baseUrl}detail/${id}`, {
        headers: { Authorization: bearerToken },
      })
      .then(({ data }) => {
        this.postData = data
        this.holidayId = data.holiday_id
        this.showForm = true
        this.isEditForm = true
      })
  },
  closeDeleteConfirm() {
    this.selectedDays = []
    this.deleteConfirm = false
    this.checkAll = false
  },
  showDeleteConfirm(id) {
    this.selectedDays = []
    this.selectedDays.push(id)
    this.deleteConfirm = true
  },
  selectAll() {
    if (this.checkAll) {
      paging().state.data.forEach((item) => {
        this.selectedDays.push(item.holiday_id)
      })
    } else {
      this.selectedDays = []
    }
  },
  multipleDeleteConfirm() {
    if (this.selectedDays.length > 0) {
      this.deleteConfirm = true
    } else {
      flashAlert(t('pilih_data_dulu'), 'negative')
    }
  },
}
