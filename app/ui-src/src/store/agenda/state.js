export default function () {
  return {
    // default FullCalendar options
    showAddForm: false,
    error: {},
    helper: {
      disableSaveButton: false,
    },
    events: [],
    calendar: {
      view: '',
      start: '',
      end: ''
    }
  }
}
