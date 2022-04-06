import state from './state'
import getters from './getters'
import mutations from './mutations'
import actions from './actions'
import { SSPaging as paging } from '../shared/ss-paging'

export default {
  namespaced: true,
  modules: {
    paging
  },
  state,
  getters,
  mutations,
  actions
}
