import { appConfig as conf } from '../../../actudent.config'

export default function () {
  return {
    error: {},
    helper: {
      disableSaveButton: false,
      showSaveButton: true,
      showDeleteButton: false,
      deleteProgress: false,
    },
    detail: {}, 
    current: 1,
    className: '',
    classID: '',
    day: '', scheduleLength: 0,
    schedule: [], // schedule list
    homework: false, scheduleID: '', journalID: '',
    presenceButtons: false, showJournalBtn: false, salinJurnal: true,
    journalStatus: 'false', archivePage: true, archiveButton: false,
    presenceGrid: true, backToArchive: false,
    presenceList: [],
  }
}
