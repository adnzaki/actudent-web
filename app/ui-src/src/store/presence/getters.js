import { Cookies, conf } from '../../composables/common'
import { date } from 'quasar'

export default {
  presenceApi() {
    return Cookies.get(conf.userType) === '1'
      ? `${conf.adminAPI}absensi/`
      : `${conf.teacherAPI}absensi/`
  },
  activeDate() {

  }
}
