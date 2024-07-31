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

// const paging = usePagingStore()

export default {
  copyClassgroup() {
    const data = JSON.stringify(this.selectedClasses)
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('kelas_copy_progress'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    admin
      .post(
        `${this.classApi}copy-classgroup`,
        { selectedClasses: data },
        {
          headers: { Authorization: bearerToken },
          transformRequest: [
            (data) => {
              return createFormData(data)
            },
          ],
        },
      )
      .then(({ data }) => {
        notifyProgress({ timeout })
        this.current = 1
        this.selectedClasses = []
        paging().reloadData()
        notifyProgress({
          message: `${t('sukses')} ${t('kelas_copy_success')}`,
          color: 'positive',
          icon: 'done',
          spinner: false,
        })
      })
      .catch((err) => {
        notifyProgress({
          message: t('kelas_copy_failed'),
          color: 'negative',
          spinner: false,
        })
      })
  },
  confirmCopyClass() {
    Dialog.create({
      title: t('konfirmasi'),
      message: t('kelas_confirm_copy'),
      cancel: t('batal'),
      persistent: true,
    }).onOk(() => {
      this.copyClassgroup()
    })
  },
  getPreviousClass() {
    const limit = 25
    paging().state.rows = limit

    paging().getData({
      token: bearerToken,
      lang: localStorage.getItem(conf.userLang),
      limit,
      offset: this.current - 1,
      orderBy: 'grade_name',
      searchBy: 'grade_name',
      sort: 'ASC',
      search: '',
      url: `${conf.adminAPI}kelas/get-kelas-sebelumnya/`,
      autoReset: {
        active: true,
        timeout: 500,
      },
    })
  },

  removeFromClassGroup({ id, grade }) {
    admin
      .get(`${this.classApi}remove-member/${id}/${grade}`, {
        headers: { Authorization: bearerToken },
      })
      .then((response) => {
        this.getClassMember(grade)
      })
  },
  addToClassGroup(payload) {
    const data = {
      id: payload.id,
      grade: payload.grade,
    }

    admin
      .post(`${this.classApi}add-member`, data, {
        headers: { Authorization: bearerToken },
        transformRequest: [
          (data) => {
            return createFormData(data)
          },
        ],
      })
      .then((response) => {
        this.getUnregisteredStudents(payload.grade)
      })
  },
  getUnregisteredStudents(gradeId) {
    paging().getData({
      token: bearerToken,
      lang: localStorage.getItem(conf.userLang),
      limit: 25,
      offset: 0,
      orderBy: 'student_name',
      searchBy: 'student_name',
      sort: 'ASC',
      search: '',
      url: `${conf.adminAPI}kelas/get-siswa/${gradeId}/`,
      autoReset: {
        active: true,
        timeout: 500,
      },
    })
  },
  deleteClass() {
    let idString
    if (this.selectedClasses.length > 1) {
      idString = this.selectedClasses.join('-')
    } else {
      idString = this.selectedClasses[0]
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
      .post(`${this.classApi}delete`, data, {
        headers: { Authorization: bearerToken },
        transformRequest: [
          (data) => {
            return createFormData(data)
          },
        ],
      })
      .then(() => {
        notifyProgress({ timeout })
        this.helper.disableSaveButton = false
        this.deleteConfirm = false
        notifyProgress({
          message: t('kelas_delete_success'),
          color: 'positive',
          icon: 'done',
          spinner: false,
        })

        // refresh data
        this.resetForm()
      })
  },
  save(payload) {
    let url
    payload.edit ? (url = `save/${payload.id}`) : (url = 'save')
    this.helper.disableSaveButton = true
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('kelas_save_progress'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    admin
      .post(`${this.classApi}${url}`, payload.data, {
        headers: { Authorization: bearerToken },
        transformRequest: [
          (data) => {
            return createFormData(data)
          },
        ],
      })
      .then((response) => {
        notifyProgress({ timeout })
        this.helper.disableSaveButton = false
        const res = response.data
        if (res.code === '500') {
          this.error = res.msg
          notifyProgress({
            message: `Error! ${t('kelas_save_error')}`,
            color: 'negative',
            spinner: false,
          })
        } else {
          this.saveStatus = 200

          this.selectedTeacher = {
            id: '',
            name: '',
          }

          this.resetForm()
          if (payload.edit) {
            this.showEditForm = false
            notifyProgress({
              message: `${t('sukses')} ${t('kelas_edit_success')}`,
              color: 'positive',
              icon: 'done',
              spinner: false,
            })
          } else {
            this.showAddForm = false
            notifyProgress({
              message: `${t('sukses')} ${t('kelas_insert_success')}`,
              color: 'positive',
              icon: 'done',
              spinner: false,
            })
          }
        }
      })
  },
  resetForm() {
    this.error = {}
    this.selectedTeacher = { id: '', name: '' }
    this.current = 1
    paging().reloadData()
  },
  getClassList(afterSave = false) {
    const limit = 25
    paging().state.rows = limit

    paging().getData({
      token: bearerToken,
      lang: localStorage.getItem(conf.userLang),
      limit,
      offset: this.current - 1,
      orderBy: 'grade_name',
      searchBy: 'grade_name',
      sort: 'ASC',
      search: '',
      url: `${conf.adminAPI}kelas/get-kelas/`,
      autoReset: {
        active: true,
        timeout: 500,
      },
    })
  },

  // ported from Vuex mutations
  getClassMember(id) {
    admin
      .get(`${this.classApi}get-member/${id}`, {
        headers: { Authorization: bearerToken },
      })
      .then((response) => {
        this.classMember.students = response.data
      })
  },
  getTeacher() {
    admin
      .get(`${this.classApi}cari-guru`, {
        headers: { Authorization: bearerToken },
      })
      .then((response) => {
        this.teachers = response.data
        if (response.data.length > 0) {
          this.teacherId = response.data[0].staff_id
        }
      })
  },
  getDetail(id) {
    this.error = {}
    admin
      .get(`${this.classApi}detail/${id}`, {
        headers: { Authorization: bearerToken },
      })
      .then((response) => {
        const res = response.data
        this.detail = res
        this.classMember.name = res.grade_name
        setTimeout(() => {
          this.showEditForm = true
        }, 500)
      })
  },
  closeDeleteConfirm() {
    this.selectedClasses = []
    this.deleteConfirm = false
    this.checkAll = false
  },
  multipleDeleteConfirm() {
    if (this.selectedClasses.length > 0) {
      this.deleteConfirm = true
    } else {
      flashAlert(t('pilih_data_dulu'), 'negative')
    }
  },
  showDeleteConfirm(id) {
    this.selectedClasses = []
    this.selectedClasses.push(id)
    this.deleteConfirm = true
  },
  selectAll() {
    if (this.checkAll) {
      paging().state.data.forEach((item) => {
        this.selectedClasses.push(item.grade_id)
      })
    } else {
      this.selectedClasses = []
    }
  },
}
