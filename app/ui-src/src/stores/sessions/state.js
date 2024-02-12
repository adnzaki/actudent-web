export default function () {
  return {
    error: {},
    helper: {
      disableSaveButton: false,
      showSaveButton: true,
      showDeleteButton: false,
      deleteProgress: false,
    },
    selectedSession: null,
    sessions: [],
    current: 1,
    deleteConfirm: false,
  }
}
