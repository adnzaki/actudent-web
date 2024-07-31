export default function () {
  return {
    baseUrl: 'libur/',
    error: {},
    disableSaveButton: false,
    holidayId: null,
    postData: {
      holiday_title: '',
      start_date: '',
      end_date: '',
    },
    checkAll: false,
    selectedDays: [],
    current: 1,
    isEditForm: false,
    showForm: false,
    saveStatus: 500,
    deleteConfirm: false,
    searchTimeout: false,
  }
}
