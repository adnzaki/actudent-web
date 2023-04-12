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
    rooms: [],
    lesson: {
      showAddForm: false,
      showEditForm: false,
      detail: {},
      list: [],
      selected: [],
      checkAll: false,
      saveStatus: 500,
      options: [],
      lessonId: ''
    },
    schedule: {
      lessonOptions: [], // this is the wrapper for normalList and inactiveList
      normalList: [],
      inactiveList: [],
      defaultLesson: '',
      defaultRoom: '',
      list: [],
      showForm: false,
      showLessonList: true, // show lesson list in schedule form
      showLessonInput: false, // show lesson input form
      showBreakInput: false, // show break input form
      isBreak: false,
      
      // list of lessons in manage lessons form
      lessonsInput: [],

      selectedDay: '', breakDuration: 0,
      toBeDeletedSchedule: [],
      allocation: '', 
      startTime: '',
      scheduleType: 'lesson', // lesson, inactive, break
      saveStatus: 500,
    },      
  }
}
