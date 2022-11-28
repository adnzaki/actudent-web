import { 
  bearerToken,
  admin,
  flashAlert,
  t
} from '../../composables/common'

export default {
  showDeactivateConfirm(state, id) {
    state.selectedUser = id
    state.deleteConfirm = true
  },
  closeDeleteConfirm(state) {
    state.selectedUser = null
    state.deleteConfirm = false
  },
}