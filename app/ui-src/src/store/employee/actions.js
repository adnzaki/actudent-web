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

export default {
  deleteEmployee({ state, dispatch }) {
    let idString
    if(state.selectedEmployees.length > 1) {
        idString = state.selectedEmployees.join('&')
    } else {
        idString = state.selectedEmployees[0]
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
    admin.post(`${state.employeeApi}delete`, data, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(response => {
        state.helper.disableSaveButton = false
        state.deleteConfirm = false
        notifyProgress({
          message: t('staff_delete_success'),
          color: 'positive',
          icon: 'done',
          spinner: false
        })

        // refresh data
        dispatch('getEmployee')
      })
  },
  save({ state, dispatch }, payload) {
    let url
    payload.edit ? url = `save/${payload.id}` : url = 'save'
    state.helper.disableSaveButton = true
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('staff_save_progress'),
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
            message: `Error! ${t('staff_error_text')}`,
            color: 'negative',
            spinner: false
          })
        } else {
          state.saveStatus = 200
          dispatch('resetForm')
          if(payload.edit) {
            state.showEditForm = false
            notifyProgress({
              message: `${t('sukses')} ${t('staff_update_success')}`,
              color: 'positive',
              icon: 'done',
              spinner: false
            })
          } else {
            state.showAddForm = false
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
  resetForm({ state, dispatch }) {
    state.error = {}
    dispatch('getEmployee')
  },
  getEmployee({ dispatch }) {
    dispatch('getData', {
      token: bearerToken,
      lang: Cookies.get(conf.userLang),
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
