const actions = {
  getEmployeeByType({ state, dispatch }, model) {
    state.paging.whereClause = model.value
    dispatch('runPaging')
  },
}

export default actions
