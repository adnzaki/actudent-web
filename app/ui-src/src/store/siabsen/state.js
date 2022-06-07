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
    disableSaveButton: false,
    permitError: {},
  }
}
