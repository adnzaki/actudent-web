export default function () {
  return {
    // default FullCalendar options
    showForm: false,
    error: {},
    helper: {
      disableSaveButton: false,
    },
    showGuestSelector: false,
    mainForm: true,
    deleteConfirm: false,
    events: [],
    calendar: {
      view: '',
      start: '',
      end: ''
    },
    isEditForm: false,
    detail: {},
    errorAccess: 'Error! Unknown access.',
    current: 1, guests: [], guestsEdit: [],
  }
}
