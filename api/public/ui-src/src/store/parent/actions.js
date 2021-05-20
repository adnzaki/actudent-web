import { 
  bearerToken, 
  admin,
  runLoadingBar,
  flashAlert,
  createFormData
} from '../../composables/common'

const actions = {
  getOrtu({ state, dispatch }) {
    runLoadingBar()
    dispatch('getData', {
      token: bearerToken,
      lang: 'indonesia',
      limit: 10,
      offset: 0,
      orderBy: 'parent_father_name',
      searchBy: [
        'parent_family_card', 'parent_father_name',
        'parent_mother_name', 'parent_phone_number'
      ],
      sort: 'ASC',
      search: '',
      url: `${state.parentURL}get-ortu/`,
      autoReset: {
        active: true,
        timeout: 500
      },
    })
  },
  onPaginationUpdate({ state, dispatch }) {
    runLoadingBar()
    dispatch('nav', state.current - 1)
  },

  // payload: { data, lang, edit, id }
  save({ state, dispatch }, payload) {
    let url
    payload.edit ? url = `save/${payload.id}` : url = 'save'
    state.helper.disableSaveButton = true
    admin.post(`${state.parentApi}${url}`, payload.data, {
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
          flashAlert(
            `Error! ${payload.lang.ortu_error_text}`,
            'negative'
          )
        } else {
          state.saveStatus = 200
          dispatch('resetForm')
          if(payload.edit) {
            flashAlert(`${payload.lang.sukses} ${payload.lang.ortu_update_success}`)
          } else {
            state.showAddForm = false
            flashAlert(`${payload.lang.sukses} ${payload.lang.ortu_insert_success}`)
          }
        }
      })
  },
  resetForm({ state, dispatch }) {
    state.error = {}
    dispatch('getOrtu')
  }
}

export default actions
