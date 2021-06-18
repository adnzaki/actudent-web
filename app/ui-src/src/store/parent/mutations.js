import { 
  bearerToken,
  admin,
} from '../../composables/common'

const mutations = {
  getDetail(state, id) {
    state.error = {}
    state.showEditForm = true
    admin.get(`${state.parentApi}detail/${id}`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        state.detail = response.data.parent  
        state.children = response.data.children  
      })
  },
  selectAll(state) {
    if (state.checkAll) {
      state.paging.data.forEach(item => {
        state.selectedParents.push(`${item.parent_id}-${item.user_id}`)
      })
    } else {
      state.selectedParents = []
    }
  } 
}

export default mutations
