export default function () {
  return {
    // default FullCalendar options
    showForm: false,
    error: {},
    helper: {
      disableSaveButton: false,
    },
    deleteConfirm: false,
    events: [],
    calendar: {
      view: '',
      start: '',
      end: ''
    },
    isEditForm: false,
    detail: {}
  }
}
