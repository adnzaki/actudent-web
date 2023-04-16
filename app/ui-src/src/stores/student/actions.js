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

import { Notify } from 'quasar'
import { usePagingStore as paging } from 'ss-paging-vue'

export default {
  deleteStudent(lang) {
    let idString
    if (this.selectedStudents.length > 1) {
      idString = this.selectedStudents.join('-')
    } else {
      idString = this.selectedStudents[0]
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
    admin.post(`${this.studentApi}delete`, data, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(() => {
        this.helper.disableSaveButton = false
        this.deleteConfirm = false
        notifyProgress({
          message: t('siswa_delete_success'),
          color: 'positive',
          icon: 'done',
          spinner: false,
          timeout
        })

        // refresh data
        this.resetForm()
      })
  },
  // payload: { data, edit, id }
  save(payload) {
    let url
    payload.edit ? url = `save/${payload.id}` : url = 'save'
    this.helper.disableSaveButton = true
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('siswa_save_progress'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    admin.post(`${this.studentApi}${url}`, payload.data, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(response => {
        notifyProgress({ timeout })
        this.helper.disableSaveButton = false
        const res = response.data
        if (res.code === '307') {
          notifyProgress({
            message: `Error! ${res.msg}`,
            color: 'negative',
            spinner: false
          })
        } else {
          if (res.code === '500') {
            this.error = res.msg
            notifyProgress({
              message: `Error! ${t('siswa_save_error')}`,
              color: 'negative',
              spinner: false
            })
          } else {
            this.saveStatus = 200

            this.selectedParent = {
              id: '',
              father: '',
              mother: ''
            }

            this.resetForm()
            if (payload.edit) {
              this.showEditForm = false
              notifyProgress({
                message: `${t('sukses')} ${t('siswa_update_success')}`,
                color: 'positive',
                icon: 'done',
                spinner: false
              })
            } else {
              this.showAddForm = false
              notifyProgress({
                message: `${t('sukses')} ${t('siswa_save_success')}`,
                color: 'positive',
                icon: 'done',
                spinner: false
              })
            }
          }
        }
      })
  },
  resetForm() {
    this.error = {}
    this.selectedParent = { id: '', father: '', mother: '' }
    this.current = 1
    paging().reloadData()
  },
  getStudents(afterSave = false) {
    const limit = 25
    paging().state.rows = limit

    paging().getData({
      token: bearerToken,
      lang: localStorage.getItem(conf.userLang),
      limit,
      offset: this.current - 1,
      orderBy: 'student_name',
      searchBy: [
        'student_nis', 'student_name'
      ],
      sort: 'ASC',
      where: null,
      search: '',
      url: `${conf.adminAPI}siswa/get-siswa/`,
      autoReset: {
        active: true,
        timeout: 500
      },
    })
  },
  getStudentsByClass(model) {
    paging().state.whereClause = model.value
    paging().runPaging()
  },
  getStudentLimit() {
    admin.get(`${this.studentApi}limit`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        this.studentLimit = response.data
      })
  },
  showDeleteConfirm(id) {
    this.selectedStudents = []
    this.selectedStudents.push(id)
    this.deleteConfirm = true
  },
  closeDeleteConfirm() {
    this.selectedStudents = []
    this.deleteConfirm = false
    this.checkAll = false
  },
  multipleDeleteConfirm() {
    if (this.selectedStudents.length > 0) {
      this.deleteConfirm = true
    } else {
      flashAlert(t('pilih_data_dulu'), 'negative')
    }
  },
  getDetail(id) {
    this.error = {}
    this.showEditForm = true
    admin.get(`${this.studentApi}detail/${id}`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        const res = response.data
        this.detail = res
        this.selectedParent.id = res.parent_id
        this.selectedParent.father = res.parent_father_name
        this.selectedParent.mother = res.parent_mother_name
      })
  },
  selectParent(data) {
    this.selectedParent = {
      id: data.parent_id,
      father: data.parent_father_name,
      mother: data.parent_mother_name
    }

    // empty search result
    this.family = []
  },
  searchParents(searchParam) {
    // prevent request until searchTimeout is true
    if (!this.searchTimeout) {
      this.searchTimeout = true

      // wait for 300ms before processing request to server
      setTimeout(() => {
        let keyword
        if (searchParam === '') {
          keyword = ''
          this.family = []
        } else {
          keyword = `/${searchParam}`
        }

        admin.get(`${this.studentApi}cari-ortu${keyword}`, {
          headers: { Authorization: bearerToken }
        })
          .then(response => {
            const res = response.data
            if (res === null) {
              this.family = []
            } else {
              this.family = res
            }
          })

        // turn back searchTimeout to false
        this.searchTimeout = false
      }, 300);
    }
  },
  getClassGroup() {
    admin.get(`${this.studentApi}get-kelas`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        this.classGroupList = response.data
        this.classGroupList.unshift({
          grade_name: t('siswa_all'),
          grade_id: 'null'
        })
      })
  },
  selectAll() {
    if (this.checkAll) {
      paging().state.data.forEach(item => {
        this.selectedStudents.push(item.student_id)
      })
    } else {
      this.selectedStudents = []
    }
  }
}