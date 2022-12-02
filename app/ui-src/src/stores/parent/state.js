import { appConfig as conf } from '../../../actudent.config'

export default function () {
  return {
    parentApi: 'orang-tua/',
    error: {},
    helper: {
      disableSaveButton: false,
      showSaveButton: true,
      showDeleteButton: false,
      deleteProgress: false,
    },
    detail: {}, userEmail: '', domain: '',
    children: [],
    motherName: '', fatherName: '',
    selectedParents: [], checkAll: false,
    current: 1,
    showAddForm: false, showEditForm: false,
    saveStatus: 500, deleteConfirm: false
  }
}
