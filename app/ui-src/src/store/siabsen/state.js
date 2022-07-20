export default function () {
  return {
    config: {},
    inStatus: '',
    outStatus: '',
    canInAbsent: false,
    canOutAbsent: false,
    isLate: false,
    showPresenceDialog: false,
    presenceType: '',
    presenceSuccess: false,
    absenceIn: {},
    absenceOut: {},
    base64String: '',
    activeDate: '',
    current: 1,
    inPhotoURL: '',
    outPhotoURL: '',
    showPresenceDetail: false,
    showPermitForm: false,
    disableSaveButton: true,
    permitError: {},
    saveStatus: 500,
    showPermitDetail: false, deleteConfirm: false,
    permitDetail: {}, selectedPermission: null,
    period: '01-2022',
    presenceDetail: {},
    presenceConfig: {
      intime: 'HH:mm',
      outtime: 'HH:mm',
      lat: '', long: '',
      tolerance: 0,
      range: 0
    },
    configError: {}, notifCounter: 0,
    scheduleDays: {
      day0: false, day1: false, day2: false, 
      day3: false, day4: false, day5: false, day6: false
    }
  }
}
