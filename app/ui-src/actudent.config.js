/**
 * Configuration for Actudent User Interface
 *
 * @author  Adnan Zaki | Wolestech DevTeam
 */

import { mode, host, uiPath, baseUrl } from './globalConfig.js'

export const appConfig = {
  // API Url for admin section
  adminAPI: `${baseUrl()}admin/`,

  // API Url for teacher section
  teacherAPI: `${baseUrl()}guru/`,

  // API Url for resource section
  coreAPI: `${baseUrl()}core/`,

  // API for testing section
  testAPI: `${baseUrl()}ui-test/`,

  // This URL will be used to redirect from
  // Actudent authentication page into main
  // application page
  homeUrl: () => {
    return (mode === 'development')
      ? 'http://localhost:8080/#/'
      : `${uiPath()}app`
  },

  host,
  uiPath,

  // Cookie key name
  cookieName: 'actudent_token',

  // Cookie expiration time in miliseconds (120 in minutes)
  cookieExp: 120 * 60 * 1000,

  // Cookie name to retrieve selected language of current user
  userLang: 'actudent_userlang',
}
