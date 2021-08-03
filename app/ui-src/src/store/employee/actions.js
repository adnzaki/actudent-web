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
      message: payload.lang.staff_save_progress,
      color: 'info',
      position: 'center',
      timeout,
    })

    payload.data.featured_image = state.helper.filename

    admin.post(`${state.employeeApi}${url}`, payload.data, {
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
            message: `Error! ${payload.lang.staff_error_text}`,
            color: 'negative',
            spinner: false
          })
        } else {
          state.saveStatus = 200
          dispatch('resetForm')
          if(payload.edit) {
            state.showEditForm = false
            notifyProgress({
              message: `${payload.lang.sukses} ${payload.lang.staff_update_success}`,
              color: 'positive',
              icon: 'done',
              spinner: false
            })
          } else {
            state.showAddForm = false
            notifyProgress({
              message: `${payload.lang.sukses} ${payload.lang.staff_insert_success}`,
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
    dispatch('getEmployee')
  },
  getEmployee({ dispatch }) {
    dispatch('getData', {
      token: bearerToken,
      lang: pengguna.value.user_language,
      limit: 10,
      offset: 0,
      orderBy: 'staff_name',
      searchBy: [
        'staff_nik', 'staff_name', 'staff_title'
      ],
      sort: 'ASC',
      where: null,
      search: '',
      url: `${conf.adminAPI}pegawai/get-pegawai/`,
      autoReset: {
        active: true,
        timeout: 500
      },
    })
  },
  getEmployeeByType({ state, dispatch }, model) {
    state.paging.whereClause = model.value
    dispatch('runPaging')
  },
}

export default actions
