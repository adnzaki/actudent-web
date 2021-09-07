/**
 * Global data registration for Actudent app,
 * so we do not need to create them on each main component
 * 
 * @author    Adnan Zaki 
 * @copyright Wolestech (c) 2021
 */

export default ({ app }) => {
  app.config.globalProperties.buildVersion = 'ac.v2.0022'
}