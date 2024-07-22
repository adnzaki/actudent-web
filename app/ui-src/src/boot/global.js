/**
 * Global data registration for Actudent app,
 * so we do not need to create them on each main component
 *
 * @author    Adnan Zaki
 * @copyright Wolestech (c) 2021
 */
import { trim, formatDate } from 'src/composables/common'

export default ({ app }) => {
  app.config.globalProperties.$buildVersion = '2.1.0 (22-07-2024)'
  ;(app.config.globalProperties.$trim = (
    text,
    length = 25,
    ellipsis = true,
  ) => {
    return text === undefined ? '' : trim(text, length, ellipsis)
  }),
    (app.config.globalProperties.$formatDate = (
      val,
      format = 'dddd, DD MMMM YYYY',
    ) => {
      return val === undefined ? '' : formatDate(val, format)
    })
}
