import { appConfig as conf } from '../../actudent.config'
import { core } from 'boot/axios'
import { Cookies } from 'quasar'
import { runLoadingBar } from 'src/composables/common'
import checkSubscription from 'src/composables/subscription'

// get token dynamically
const bearerToken = `Bearer ${Cookies.get(conf.cookieName)}`

function validateToken (validator, teacherReport) {
  runLoadingBar()
  if(Cookies.has(conf.cookieName)) {
    core.get(`validate-token/${validator}`, {
      headers: {
        Authorization: bearerToken
      }
    })
      .then(({ data }) => {
        if (data.status === 503) {
          redirect()
          console.warn('Connection to API failed. Any request will be rejected and redirected to Login page.')
        } else {
          console.info('Successfully established connection to Actudent API.')
          if(teacherReport && data.check === 0) {
            window.location.href = conf.teacherHomeUrl()
          }

          localStorage.setItem(conf.userLang, data.lang)
          console.info('App language synced. Need a full reload to take effect')
        }
      })
      .catch((error) => {
        console.error('Error:', error)
        redirect()
      })
  } else {
    redirect()
  }
}

function redirect() {
  // when the page is accessed with full reload
  // we have to wait for until the entire page is fully loaded
  window.onload = event => window.location.href = conf.loginUrl()

  // and we use this way for SPA routing,
  // because the entire page has been fully loaded
  if(document.readyState === 'complete') {
    window.location.href = conf.loginUrl()
  }
}

function routeValidator(type = 'is_admin', teacherReport = false) {
  checkSubscription()
  validateToken(type, teacherReport)
}

export { 
  validateToken, 
  redirect, 
  bearerToken, 
  routeValidator
}
