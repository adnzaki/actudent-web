export default function () {
  return {
    classApi: 'kelas/',
    error: {},
    helper: {
      disableSaveButton: false,
      showSaveButton: true,
      showDeleteButton: false,
      deleteProgress: false,
    },
    selectedTeacher: {
      id: '', name: '',
    },
    teachers: [],
    detail: {}, 
    checkAll: false, selectedClasses: [],
    current: 1,
    showAddForm: false, showEditForm: false,
    saveStatus: 500, deleteConfirm: false,
    searchTimeout: false,

    // state for class member page only
    classMember: {
      name: '',
      students: [],
      showForm: false,
    }
  }
}
