/**
 * Global data registration for Actudent app,
 * so we do not need to create them on each main component
 * 
 * @author    Adnan Zaki 
 * @copyright Wolestech (c) 2021
 */
import { trim } from 'src/composables/common'

export default ({ app }) => {
  app.config.globalProperties.$buildVersion = 'beta-1.ac.v2.0041'
  app.config.globalProperties.$trim = (text, length = 25) => trim(text, length)
}