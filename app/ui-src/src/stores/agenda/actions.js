import { 
  bearerToken,
  axios,
  timeout,
  createFormData,
  t,
  conf
} from '../../composables/common'

import { Notify } from 'quasar'
import { usePagingStore } from 'ss-paging-vue'

const paging = usePagingStore()

export default {
  getUsers(type) {
    paging.getData({
      token: bearerToken,
      lang: localStorage.getItem(conf.userLang),
      limit: 25,
      offset: this.current - 1,
      orderBy: 'user_name',
      searchBy: 'user_name',
      sort: 'ASC',
      search: '',
      url: `${conf.adminAPI}agenda/get-users/${type}/`,
      autoReset: {
        active: true,
        timeout: 500
      },
    })
  },
  delete() {
    this.helper.disableSaveButton = true
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('agenda_delete_progress'),
      color: 'info',
      position: 'center',
      timeout,
    })

    axios.get(`${this.agendaApi}delete/${this.detail.agenda_id}`, {
      headers: { Authorization: bearerToken }
    })
      .then(({ data }) => {
        notifyProgress({ timeout })
        if(data.status === 'OK') {
          this.helper.disableSaveButton = false
          notifyProgress({
            message: `${t('sukses')} ${t('agenda_delete_success')}`,
            color: 'positive',
            icon: 'done',
            spinner: false
          })
          
          this.deleteConfirm = false
          this.resetDefault()
        } else {
          notifyProgress({
            message: this.errorAccess,
            color: 'negative',
            spinner: false
          })
        }
      })
  },
  getDetail(id) {
    axios.get(`${this.agendaApi}get-event-detail/${id}`, {
      headers: { Authorization: bearerToken }
    })
      .then(({ data }) => {
        this.detail = data.data
        this.showForm = true
        this.isEditForm = true
        this.guestsEdit = data.guests
      })
  },
  save(payload) {
    let url
    payload.edit ? url = `save/${payload.id}` : url = 'save'
    this.helper.disableSaveButton = true
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('agenda_saving_progress'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    axios.post(`${this.agendaApi}${url}`, payload.data, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(({ data }) => {
        this.helper.disableSaveButton = false
        notifyProgress({ timeout })
        if(data.code === '500') {
          this.error = data.msg
          notifyProgress({
            message: `Error! ${t('agenda_error_text')}`,
            color: 'negative',
            spinner: false
          })
        } else if(data.code === '200') {
          this.saveStatus = 200
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

          this.resetDefault()
        } else {
          notifyProgress({
            message: this.errorAccess,
            color: 'negative',
            spinner: false
          })
        }
      })
  },
  resetDefault() {
    this.getEvents({
      view: this.calendar.view,
      start: this.calendar.start,
      end: this.calendar.end
    })
    
    this.error = {}
    this.showForm = false
    this.guests = []
    this.guestsEdit = []
  },
  getEvents({ view, start, end }) {
    axios.get(`${this.agendaApi}get-events/${start}/${end}`, {
      headers: { Authorization: bearerToken }
    })
      .then(({ data }) => {
        this.events = data
      })
  },

  // From Vuex mutations
  // ---------------------------------------------------------------
  closeDeleteConfirm() {
    this.deleteConfirm = false
  }
}
