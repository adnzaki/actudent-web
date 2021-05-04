import { appConfig as conf } from '../../../actudent.config'

export default function () {
  return {
    parentURL: `${conf.adminAPI}orang-tua/`,
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
      parents: [], checkAll: false,
      current: 1,
  }
}
