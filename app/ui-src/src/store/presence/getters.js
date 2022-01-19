import { Cookies, conf } from '../../composables/common'

export default {
  presenceApi() {
    return Cookies.get(conf.userType) === 1
      ? `${conf.adminAPI}absensi/`
      : `${conf.teacherAPI}absensi/`
  }
}
