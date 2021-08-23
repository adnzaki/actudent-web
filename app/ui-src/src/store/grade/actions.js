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

const actions = {
  deleteClass({ state, dispatch }) {
    let idString
    if(state.selectedClasses.length > 1) {
        idString = state.selectedClasses.join('-')
    } else {
        idString = state.selectedClasses[0]
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
    admin.post(`${state.classApi}delete`, data, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(() => {
        state.helper.disableSaveButton = false
        state.deleteConfirm = false
        notifyProgress({
          message: t('kelas_delete_success'),
          color: 'positive',
          icon: 'done',
          spinner: false
        })

        // refresh data
        dispatch('getClassList')
      })
  },
  save({ state, dispatch }, payload) {
    let url
    payload.edit ? url = `save/${payload.id}` : url = 'save'
    state.helper.disableSaveButton = true
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('kelas_save_progress'),
      color: 'info',
      position: 'center',
      timeout,
    })

    admin.post(`${state.classApi}${url}`, payload.data, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(response => {
        state.helper.disableSaveButton = false
        const res = response.data
        if(res.code === '500') {
          state.error = res.msg
          notifyProgress({
            message: `Error! ${t('kelas_save_error')}`,
            color: 'negative',
            spinner: false
          })
        } else {
          state.saveStatus = 200

          state.selectedTeacher = {
            id: '',
            name: ''
          }

          dispatch('resetForm')
          if(payload.edit) {
            state.showEditForm = false
            notifyProgress({
              message: `${t('sukses')} ${t('kelas_edit_success')}`,
              color: 'positive',
              icon: 'done',
              spinner: false
            })
          } else {
            state.showAddForm = false
            notifyProgress({
              message: `${t('sukses')} ${t('kelas_insert_success')}`,
              color: 'positive',
              icon: 'done',
              spinner: false
            })
          }
        }
      })
  },
  resetForm({ state, dispatch }) {
    state.error = {}
    state.selectedTeacher = { id: '', name: '' }
    dispatch('getClassList')
  },
  getClassList({ dispatch }) {
    dispatch('getData', {
      token: bearerToken,
      lang: pengguna.value.user_language,
      limit: 10,
      offset: 0,
      orderBy: 'grade_name',
      searchBy: 'grade_name',
      sort: 'ASC',
      search: '',
      url: `${conf.adminAPI}kelas/get-kelas/`,
      autoReset: {
        active: true,
        timeout: 500
      },
    })
  },
  showGroupMember({ state, commit }, payload) {}
}

export default actions