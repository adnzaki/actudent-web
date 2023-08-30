export default function () {
  return {
    postApi: 'post/',
    error: {},
    helper: {
      disableSaveButton: false,
      showSaveButton: true,
      showDeleteButton: false,
      deleteProgress: false,
    },
    postType: 'all',
    mypost: 0,
    detail: {},
    checkAll: false, selectedPosts: [],
    current: 1,
    showAddForm: false, showEditForm: false,
    saveStatus: 500, deleteConfirm: false,
    searchTimeout: false,
  }
}
