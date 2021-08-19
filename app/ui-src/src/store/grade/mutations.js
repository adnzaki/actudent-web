import { 
  bearerToken,
  admin,
  flashAlert
} from '../../composables/common'

const mutations = {
  selectTeacher(state, data) {
    state.selectedTeacher = {
      id: data.staff_id,
      name: data.staff_name
    }

    // empty search result
    state.teachers = []
  },
  searchTeacher(state, searchParam) {
    // prevent request until searchTimeout is true
    if(!state.searchTimeout) {
      state.searchTimeout = true

      // wait for 300ms before processing request to server
      setTimeout(() => {
        let keyword
        if (searchParam === '') {
          keyword = ''
          state.teachers = []
        } else {
          keyword = `/${searchParam}`
        }
    
        admin.get(`${state.classApi}cari-guru${keyword}`, {
          headers: { Authorization: bearerToken }
        })
          .then(response => {
            const res = response.data
            if (res === null) {
              state.teachers = []
            } else {
              state.teachers = res
            }
          })     
          
          // turn back searchTimeout to false
          state.searchTimeout = false
      }, 300);
    }
  },
  getDetail(state, id) {
    state.error = {}
    state.showEditForm = true
    admin.get(`${state.classApi}detail/${id}`, {
      headers: { Authorization: bearerToken }
    })
      .then(response => {
        const res = response.data
        state.detail = res
        state.classMember.name = res.grade_name
        state.selectedTeacher.id = res.teacher_id
        state.selectedTeacher.name = res.staff_name
      })
  },
  closeDeleteConfirm(state) {
    state.selectedClasses = []
    state.deleteConfirm = false
    state.checkAll = false
  },
  multipleDeleteConfirm(state, lang) {
    if(state.selectedClasses.length > 0) {
      state.deleteConfirm = true
    } else {
      flashAlert(lang.pilih_data_dulu, 'negative')
    }
  },
  showDeleteConfirm(state, id) {
    state.selectedClasses = []
    state.selectedClasses.push(id)
    state.deleteConfirm = true
  },
  selectAll(state) {
    if (state.checkAll) {
      state.paging.data.forEach(item => {
        state.selectedClasses.push(item.grade_id)
      })
    } else {
      state.selectedClasses = []
    }
  } 
}

export default mutations