import { appConfig as conf } from '../../../actudent.config'

export default function () {
  return {
    parentURL: `${conf.adminAPI}orang-tua/`,
    parentApi: 'orang-tua/',
    error: {},
    helper: {
      disableSaveButton: false,
      showSaveButton: true,
      showDeleteButton: false,
      deleteProgress: false,
    },
    parentDetail: [], userEmail: '', domain: '',
    children: [],
    motherName: '', fatherName: '',
    selectedParents: [], checkAll: false,
    current: 1,
    showAddForm: false, saveStatus: 500
  }
}
