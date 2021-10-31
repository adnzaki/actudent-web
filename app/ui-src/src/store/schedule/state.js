export default function () {
  return {
    scheduleApi: 'jadwal/',
    error: {},
    helper: {
      disableSaveButton: false,
      showSaveButton: true,
      showDeleteButton: false,
      deleteProgress: false,
    },
    detail: {}, 
    current: 1,
    showSettingsForm: false,
    showAddForm: false, showEditForm: false,
    saveStatus: 500, deleteConfirm: false,
    searchTimeout: false,
    className: '',
    lesson: {
      showForm: false,
      list: [],
      selected: [],
      checkAll: false
    }
  }
}
