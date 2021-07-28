import { 
  bearerToken,
  admin,
  flashAlert
} from '../../composables/common'

const mutations = {
  getDetail(state, id) {

  },
  showDeleteConfirm(state) {

  },
  multipleDeleteConfirm(state, lang) {
    
  },
  selectAll(state) {
    if (state.checkAll) {
      state.paging.data.forEach(item => {
        state.selectedEmployees.push(item.staff_id)
      })
    } else {
      state.selectedEmployees = []
    }
  } 
}

export default mutations

