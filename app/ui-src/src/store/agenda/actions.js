import { 
  bearerToken,
  axios,
  timeout,
  createFormData,
  t,
} from '../../composables/common'

import { Notify } from 'quasar'

export default {
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
        } else {
          state.saveStatus = 200
          dispatch('resetForm')
          if(payload.edit) {
            state.showEditForm = false
            notifyProgress({
              message: `${t('sukses')} ${t('agenda_edit_success')}`,
              color: 'positive',
              icon: 'done',
              spinner: false
            })
          } else {
            state.showAddForm = false
            notifyProgress({
              message: `${t('sukses')} ${t('agenda_insert_success')}`,
              color: 'positive',
              icon: 'done',
              spinner: false
            })
          }
        }
      })
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
