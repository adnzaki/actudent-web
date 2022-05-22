import { 
  bearerToken,
  axios,
  timeout,
  createFormData,
  t,
} from '../../composables/common'

import { Notify } from 'quasar'

export default {
  delete({ state, getters, dispatch }) {
    state.helper.disableSaveButton = true
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('agenda_delete_progress'),
      color: 'info',
      position: 'center',
      timeout,
    })

    axios.get(`${getters.agendaApi}delete/${state.detail.agenda_id}`, {
      headers: { Authorization: bearerToken }
    })
      .then(({ data }) => {
        if(data.status === 'OK') {
          state.helper.disableSaveButton = false
          notifyProgress({
            message: `${t('sukses')} ${t('agenda_delete_success')}`,
            color: 'positive',
            icon: 'done',
            spinner: false
          })
          
          state.deleteConfirm = false
          dispatch('resetDefault')
        } else {
          notifyProgress({
            message: state.errorAccess,
            color: 'negative',
            spinner: false
          })
        }
      })
  },
  getDetail({ state, getters }, id) {
    axios.get(`${getters.agendaApi}get-event-detail/${id}`, {
      headers: { Authorization: bearerToken }
    })
      .then(({ data }) => {
        state.detail = data.data
        state.showForm = true
        state.isEditForm = true
      })
  },
  save({ state, getters, dispatch }, payload) {
    let url
    payload.edit ? url = `save/${payload.id}` : url = 'save'
    state.helper.disableSaveButton = true
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('agenda_saving_progress'),
      color: 'info',
      position: 'center',
      timeout,
    })

    axios.post(`${getters.agendaApi}${url}`, payload.data, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(({ data }) => {
        state.helper.disableSaveButton = false
        if(data.code === '500') {
          state.error = data.msg
          notifyProgress({
            message: `Error! ${t('agenda_error_text')}`,
            color: 'negative',
            spinner: false
          })
        } else if(data.code === '200') {
          state.saveStatus = 200
          if(payload.edit) {
            notifyProgress({
              message: `${t('sukses')} ${t('agenda_edit_success')}`,
              color: 'positive',
              icon: 'done',
              spinner: false
            })
          } else {
            notifyProgress({
              message: `${t('sukses')} ${t('agenda_insert_success')}`,
              color: 'positive',
              icon: 'done',
              spinner: false
            })
          }

          dispatch('resetDefault')
        } else {
          notifyProgress({
            message: state.errorAccess,
            color: 'negative',
            spinner: false
          })
        }
      })
  },
  resetDefault({ state, dispatch }) {
    dispatch('getEvents', {
      view: state.calendar.view,
      start: state.calendar.start,
      end: state.calendar.end
    })
    
    state.error = {}
    state.showForm = false
  },
  getEvents({ state, getters, dispatch }, { view, start, end }) {
    axios.get(`${getters.agendaApi}get-events/${start}/${end}`, {
      headers: { Authorization: bearerToken }
    })
      .then(({ data }) => {
        state.events = data
      })
  }
}
