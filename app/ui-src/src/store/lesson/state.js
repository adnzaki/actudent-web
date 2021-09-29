export default function () {
  return {
    roomApi: 'ruang/',
    error: {},
    helper: {
      disableSaveButton: false,
      showSaveButton: true,
      showDeleteButton: false,
      deleteProgress: false,
    },
    detail: {}, 
    checkAll: false, selectedLessons: [],
    current: 1,
    showAddForm: false, showEditForm: false,
    saveStatus: 500, deleteConfirm: false,
    searchTimeout: false,
  }
}
