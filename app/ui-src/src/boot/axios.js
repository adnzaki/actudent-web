import { boot } from 'quasar/wrappers'
import axios from 'axios'
import { appConfig as conf } from '../../actudent.config'

const admin = axios.create({ baseURL: conf.adminAPI })
const teacher = axios.create({ baseURL: conf.teacherAPI })
const core = axios.create({ baseURL: conf.coreAPI })

export default boot(({ app }) => {
  // for use inside Vue files (Options API) through this.$axios and this.$api

  app.config.globalProperties.$axios = axios
  // ^ ^ ^ this will allow you to use this.$axios (for Vue Options API form)
  //       so you won't necessarily have to import axios in each vue file

  app.config.globalProperties.$admin = admin
  app.config.globalProperties.$teacher = teacher
  app.config.globalProperties.$core = core
  // ^ ^ ^ this will allow you to use this.$api (for Vue Options API form)
  //       so you can easily perform requests against your app's API
})

export { axios, admin, teacher, core }
