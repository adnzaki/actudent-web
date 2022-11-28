export default function () {
  return {
    studentApi: 'pengguna/',
    error: {},
    helper: {
      disableSaveButton: false,
      showSaveButton: true,
      showDeleteButton: false,
      deleteProgress: false,
    },
    searchParam: '',
    detail: {}, 
    current: 1,
    showAddForm: false, showEditForm: false,
    saveStatus: 500, deleteConfirm: false,
    searchTimeout: false,
  }
}
