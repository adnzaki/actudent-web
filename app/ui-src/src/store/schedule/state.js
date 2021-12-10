export default function () {
  return {
    scheduleApi: 'jadwal/',
    error: {},
    helper: {
      disableSaveButton: false,
      showSaveButton: true,
      showDeleteButton: false,
      deleteProgress: false,
    },
    detail: {}, 
    current: 1,
    showSettingsForm: false,
    showAddForm: false, showEditForm: false,
    saveStatus: 500, deleteConfirm: false,
    searchTimeout: false,
    className: '',
    classID: '',
    lesson: {
      showAddForm: false,
      showEditForm: false,
      detail: {},
      list: [],
      selected: [],
      checkAll: false,
      saveStatus: 500,
      options: [],
    },
    schedule: {
      isBreak: false,
      showInput: false,
      
      // list of lessons in manage lessons form
      lessonsInput: [],

      selectedDay: '', breakDuration: 0,
      toBeDeletedSchedule: [],
      allocation: '', scheduleType: 'lesson'
    },      
  }
}
