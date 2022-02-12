export default function () {
  return {
    error: {},
    helper: {
      disableSaveButton: false,
      showSaveButton: true,
      showDeleteButton: false,
      deleteProgress: false,
      homework: false
    },
    showJournalForm: false,
    saveStatus: 500,
    journal: {}, 
    homework: {},
    current: 1,
    className: '',
    classID: '',
    day: '', scheduleLength: 0,
    schedule: [], // schedule list
    scheduleID: '', journalID: '',
    presenceButtons: false, showJournalBtn: false, salinJurnal: true,
    journalStatus: 'false', archivePage: true, archiveButton: false,
    presenceGrid: true, backToArchive: false,
    presenceList: [],
    checkAll: false, 
    studentPresence: [] // students to be presented
  }
}
