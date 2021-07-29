import { baseUrl } from '../../../globalConfig'

export default function () {
  return {
    employeeApi: 'pegawai/',
    error: {},
    helper: {
      disableSaveButton: false,
      fileUploaded: '',
      filename: '',
      uploadProgress: false,
      imageURL: `${baseUrl()}/images/pegawai/`,
      currentImage: '',
      userID: null,
      validImage: false,
    },
    employeeDetail: {}, userEmail: '', domain: '',
    employeeType: '', selectedEmployees: [], checkAll: false,
    current: 1,
    showAddForm: false, showEditForm: false,
    saveStatus: 500, deleteConfirm: false,
  }
}
