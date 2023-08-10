/**
 * Configuration for Actudent User Interface
 *
 * @author  Adnan Zaki | Wolestech DevTeam
 */

import { mode, host, uiPath, baseUrl } from './globalConfig.js'

const baseAppURL = window.location.origin

export const appConfig = {
  // API Url for admin section
  adminAPI: `${baseUrl()}admin/`,

  // API Url for teacher section
  teacherAPI: `${baseUrl()}guru/`,

  // API Url for resource section
  coreAPI: `${baseUrl()}core/`,

  // API for installing database
  installAPI: `${baseUrl()}install/`,

  // API for testing section
  testAPI: `${baseUrl()}ui-test/`,

  // This URL will be used to redirect from
  // Actudent authentication page into main
  // application page
  homeUrl: () => {
    return (mode === 'development')
      ? `${baseAppURL}/#/`
      : `${uiPath()}app`
  },
  teacherHomeUrl: () => {
    return (mode === 'development')
      ? `${baseAppURL}/#/teacher/home`
      : `${uiPath()}app/#/teacher/home`
  },
  loginUrl: () => {
    return (mode === 'development')
      ? `${baseAppURL}/#/login`
      : `${uiPath()}app/#/login`
  },

  host,
  uiPath,
  mode,
  reportPath: `${uiPath()}app/report/`,

  // Cookie key name
  cookieName: 'actudent_token',

  // Cookie expiration time in miliseconds (120 in minutes)
  cookieExp: 120 * 60 * 1000,

  // localStorage name to retrieve selected language of current user
  userLang: 'ac_userlang',

  // Cookie name to retrieve user type of current user
  userType: 'actudent_usertype'
}
