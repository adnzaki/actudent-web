const mutations = {
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
