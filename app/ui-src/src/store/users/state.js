export default function () {
  return {
    userApi: 'pengguna/',
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
    showForm: false,
    saveStatus: 500,
    searchTimeout: false,
  }
}
