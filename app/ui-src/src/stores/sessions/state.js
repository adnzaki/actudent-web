export default function () {
  return {
    error: {},
    helper: {
      disableSaveButton: false,
      showSaveButton: true,
      showDeleteButton: false,
      deleteProgress: false,
    },
    selectedTeacher: {
      id: '',
      name: '',
    },
    sessions: [],
    current: 1,
    showAddForm: false,
    showEditForm: false,
    saveStatus: 500,
    deleteConfirm: false,
    searchTimeout: false,
  }
}
