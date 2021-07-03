export default function () {
  return {
    studentApi: 'siswa/',
    studentLimit: '',
    error: {},
    helper: {
      disableSaveButton: false,
      showSaveButton: true,
      showDeleteButton: false,
      deleteProgress: false,
    },
    classGroupList: [], family: [],
    searchParam: '',
    selectedParent: {
      id: '', father: '', mother: ''
    },
    detail: {}, 
    checkAll: false, selectedStudents: [],
    current: 1,
    showAddForm: false, showEditForm: false,
    saveStatus: 500, deleteConfirm: false,
    searchTimeout: false,
  }
}
