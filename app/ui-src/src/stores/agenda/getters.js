import { Cookies, conf } from '../../composables/common'

export default {
  agendaApi() {
    return Cookies.get(conf.userType) === '1'
      ? `${conf.adminAPI}agenda/`
      : `${conf.teacherAPI}agenda/`
  }
}
