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

export default {
  deleteLesson({ state, dispatch }) {
    let idString
    if(state.selectedLessons.length > 1) {
        idString = state.selectedLessons.join('-')
    } else {
        idString = state.selectedLessons[0]
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
    admin.post(`${state.lessonApi}delete`, data, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(() => {
        state.helper.disableSaveButton = false
        state.deleteConfirm = false
        notifyProgress({
          message: t('mapel_delete_success'),
          color: 'positive',
          icon: 'done',
          spinner: false
        })

        // refresh data
        dispatch('resetForm')
      })
  },
  save({ state, dispatch }, payload) {
    let url
    payload.edit ? url = `save/${payload.id}` : url = 'save'
    state.helper.disableSaveButton = true
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('mapel_save_progress'),
      color: 'info',
      position: 'center',
      timeout,
    })

    admin.post(`${state.lessonApi}${url}`, payload.data, {
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
            message: `Error! ${t('mapel_error_text')}`,
            color: 'negative',
            spinner: false
          })
        } else {
          state.saveStatus = 200

          dispatch('resetForm')
          if(payload.edit) {
            state.showEditForm = false
            notifyProgress({
              message: `${t('sukses')} ${t('mapel_update_success')}`,
              color: 'positive',
              icon: 'done',
              spinner: false
            })
          } else {
            state.showAddForm = false
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
  resetForm({ state, dispatch }) {
    state.error = {}
    state.current = 1
    dispatch('getLessons', true)
  },
  getLessons({ state, dispatch }, afterSave = false) {
    const limit = 25
    state.paging.rows = limit

    dispatch('getData', {
      token: bearerToken,
      lang: localStorage.getItem(conf.userLang),
      limit: afterSave ? state.paging.limit : limit,
      offset: state.current - 1,
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
}