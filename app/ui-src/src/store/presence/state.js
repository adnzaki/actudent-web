export default function () {
  return {
    error: {},
    helper: {
      disableSaveButton: false,
      showSaveButton: true,
      showDeleteButton: false,
      deleteProgress: false,
      homework: false,
      activeDate: '',
      activeDay: 0,
    },
    showJournalForm: false,
    showPermissionForm: false,

    // model for Journal Form
    journal: { 
      description: '',
      homework_title: '',
      homework_description: '',
      due_date: ''
    }, 
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
    studentPresence: [], // students to be presented
    presenceUrl: '', // presence URL
    permissionNote: '',
    selectedPeriod: {
      month: '1', year: 2022
    },
    monthlySummary: {},
    showMonthTable: false,
  }
}
