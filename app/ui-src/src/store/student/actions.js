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

const actions = {
  deleteStudent({ state, dispatch }, lang) {
    let idString
    if(state.selectedStudents.length > 1) {
        idString = state.selectedStudents.join('-')
    } else {
        idString = state.selectedStudents[0]
    }

    // show notify
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('progress_hapus'),
      color: 'info',
      position: 'center',
      timeout,
    })

    const data = { id: idString }
    admin.post(`${state.studentApi}delete`, data, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(() => {
        state.helper.disableSaveButton = false
        state.deleteConfirm = false
        notifyProgress({
          message: t('siswa_delete_success'),
          color: 'positive',
          icon: 'done',
          spinner: false
        })

        // refresh data
        dispatch('getStudents')
      })
  },
  // payload: { data, edit, id }
  save({ state, dispatch }, payload) {
    let url
    payload.edit ? url = `save/${payload.id}` : url = 'save'
    state.helper.disableSaveButton = true
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('siswa_save_progress'),
      color: 'info',
      position: 'center',
      timeout,
    })

    admin.post(`${state.studentApi}${url}`, payload.data, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(response => {
        state.helper.disableSaveButton = false
        const res = response.data
        if(res.code === '307') {
          notifyProgress({
            message: `Error! ${res.msg}`,
            color: 'negative',
            spinner: false
          })
        } else {
          if(res.code === '500') {
            state.error = res.msg
            notifyProgress({
              message: `Error! ${t('siswa_save_error')}`,
              color: 'negative',
              spinner: false
            })
          } else {
            state.saveStatus = 200

            state.selectedParent = {
              id: '',
              father: '',
              mother: ''
            }

            dispatch('resetForm')
            if(payload.edit) {
              state.showEditForm = false
              notifyProgress({
                message: `${t('sukses')} ${t('siswa_update_success')}`,
                color: 'positive',
                icon: 'done',
                spinner: false
              })
            } else {
              state.showAddForm = false
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
  resetForm({ state, dispatch }) {
    state.error = {}
    state.selectedParent = { id: '', father: '', mother: '' }
    dispatch('getStudents')
  },
  getStudents({ state, dispatch }) {
    // mutate paging.rows in order to affect
    // model-value on QSelect
    const limit = 25
    state.paging.rows = limit

    dispatch('getData', {
      token: bearerToken,
      lang: Cookies.get(conf.userLang),
      limit,
      offset: 0,
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
  getStudentsByClass({ state, dispatch }, model) {
    state.paging.whereClause = model.value
    dispatch('runPaging')
  },
}

export default actions
