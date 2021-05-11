import { bearerToken } from '../../composables/common'
import runLoadingBar from '../../composables/loading-bar'

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
  }
}

export default actions
