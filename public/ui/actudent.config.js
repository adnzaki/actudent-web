/**
 * Configuration for Actudent User Interface
 *
 * @author  Adnan Zaki | Wolestech DevTeam
 */

import { mode, baseUrl } from '../globalConfig.js'

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
      : `${baseUrl()}main`
  },

  // Cookie key name
  cookieName: 'actudent_token',

  // Cookie expiration time in miliseconds (120 in minutes)
  cookieExp: 120 * 60 * 1000,

  // token for testing only
  testToken: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MSwiZW1haWwiOiJhZG1pbkBsb2NhbGhvc3QiLCJuYW1hIjoiQWRuYW4gWmFraSIsInVzZXJMZXZlbCI6IjEiLCJsb2dnZWRfaW4iOnRydWV9.JtWPsftp54MqhwoSOIGCQuo44XTeH4izzeU4AZhMrWU'
}
