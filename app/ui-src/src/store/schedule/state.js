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
      list: [],
      showForm: false,
      showLessonList: true, // show lesson list in schedule form
      showLessonInput: false, // show lesson input form
      showBreakInput: false, // show break input form
      showInactiveInput: false, // show input taken from inactive lesson
      isBreak: false,
      
      // list of lessons in manage lessons form
      lessonsInput: [],

      selectedDay: '', breakDuration: 0,
      toBeDeletedSchedule: [],
      allocation: '', scheduleType: 'lesson',
      saveStatus: 500,
    },      
  }
}
