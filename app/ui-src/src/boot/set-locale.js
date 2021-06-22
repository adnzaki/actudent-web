/**
 * Accessible language array for the whole app,
 * so we do not have to import this mixin on each component
 * 
 * @author    Adnan Zaki
 * @copyright Wolestech (c) 2021
 */

import { boot } from 'quasar/wrappers'
import locale from '../mixins/fetch-lang'

export default boot( ({ app }) => {
  app.mixin(locale)   
})