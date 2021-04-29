import SSPaging from './ss-paging'
import { appConfig as conf } from '../../actudent.config'
import { bearerToken } from '../composables/validate-token'
import runLoadingBar from '../composables/loading-bar'

const parent = {
  mixins: [SSPaging],
  data() {
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
  },
  methods: {
    getOrtu() {
      runLoadingBar()
      this.getData({
        token: bearerToken,
        lang: 'indonesia',
        limit: 10,
        offset: 0,
        orderBy: 'parent_father_name',
        searchBy: [
          'parent_family_card', 'parent_father_name',
          'parent_mother_name', 'parent_phone_number'
        ],
        sort: 'ASC',
        search: '',
        url: `${this.parentURL}get-ortu/`,
      })
    },
    onPaginationUpdate() {
      runLoadingBar()
      this.nav(this.current - 1)
    }
  }
}

export default parent
