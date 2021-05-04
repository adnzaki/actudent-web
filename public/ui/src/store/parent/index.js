import state from './state'
import * as getters from './getters'
import * as mutations from './mutations'
import * as actions from './actions'
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
