import { 
  bearerToken,
  admin,
  flashAlert
} from '../../composables/common'

const mutations = {
  showDeleteConfirm(state, id) {

  },
  getDetail(state, id) {

  },
  selectParent(state, data) {
    state.selectedParent = {
      id: data.parent_id,
      father: data.parent_father_name,
      mother: data.parent_mother_name
    }

    // empty search result
    state.family = []
  },
  searchParents(state, searchParam) {
    // prevent request until searchTimeout is true
    if(!state.searchTimeout) {
      state.searchTimeout = true

      // wait for 300ms before processing request to server
      setTimeout(() => {
        let keyword
        if (searchParam === '') {
          keyword = ''
          state.family = []
        } else {
          keyword = `/${searchParam}`
        }
    
        admin.get(`${state.studentApi}cari-ortu${keyword}`, {
          headers: { Authorization: bearerToken }
        })
          .then(response => {
            const res = response.data
            if (res === null) {
              state.family = []
            } else {
              state.family = res
            }
          })     
          
          // turn back searchTimeout to false
          state.searchTimeout = false
      }, 300);
    }
  },
  getClassGroup(state) {
    admin.get(`${state.studentApi}get-kelas`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        state.classGroupList = response.data
      })
  },
  selectAll(state) {
    if (state.checkAll) {
      state.paging.data.forEach(item => {
        state.selectedStudents.push(item.student_id)
      })
    } else {
      state.selectedStudents = []
    }
  } 
}

export default mutations