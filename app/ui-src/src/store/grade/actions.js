import { 
  Cookies,
  conf,
  bearerToken,
  admin,
  timeout,
  errorNotif,
  createFormData,
  pengguna
} from '../../composables/common'

import { Notify } from 'quasar'

const actions = {
  save({ state, dispatch }, payload) {
    let url
    payload.edit ? url = `save/${payload.id}` : url = 'save'
    state.helper.disableSaveButton = true
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: payload.lang.kelas_save_progress,
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
            message: `Error! ${payload.lang.kelas_save_error}`,
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
              message: `${payload.lang.sukses} ${payload.lang.kelas_edit_success}`,
              color: 'positive',
              icon: 'done',
              spinner: false
            })
          } else {
            state.showAddForm = false
            notifyProgress({
              message: `${payload.lang.sukses} ${payload.lang.kelas_insert_success}`,
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