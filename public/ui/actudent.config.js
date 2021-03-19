/**
 * Configuration for Actudent User Interface
 *
 * @author  Adnan Zaki | Wolestech DevTeam
 */
const baseUrl = `http://${window.location.hostname}/actudent-v2/public/`

const mode = 'development'

export const appConfig = {
  // API Url for admin section
  adminAPI: `${baseUrl}admin/`,

  // API Url for teacher section
  teacherAPI: `${baseUrl}guru/`,

  // API for testing section
  testAPI: `${baseUrl}ui-test/`,

  // This URL will be used to redirect from
  // Actudent authentication page into main
  // application page
  homeUrl: () => {
    return (mode === 'development')
      ? 'localhost:8080/#/'
      : `${baseUrl}ui/dist/pwa/home`
  },

  // Cookie key name
  cookieName: 'actudent_token',

  // Cookie expiration time in minutes
  cookieExp: 120
}
