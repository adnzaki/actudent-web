import { appConfig as conf } from '../../actudent.config'
import { core } from 'boot/axios'
import { Cookies } from 'quasar'
import { mode } from '../../globalConfig'
import { runLoadingBar } from 'src/composables/common'
// import route from '../router'

// get token dynamically
const bearerToken = `Bearer ${Cookies.get(conf.cookieName)}`

function checkSubscription() {
  core.get(`check-subscription`, {
    headers: {
      Authorization: bearerToken
    }
  })
    .then(response => {
      if (response.data.status === 112) {
        console.error('Subscription expired, access revoked.')
        redirect()
      }
    })
    .catch((error) => {
      console.error('Error:', error)
      redirect()
    })
}

function validateToken (validator) {
  runLoadingBar()
  if(Cookies.has(conf.cookieName)) {
    core.get(`validate-token/${validator}`, {
      headers: {
        Authorization: bearerToken
      }
    })
      .then(response => {
        if (response.data.status === 503) {
          redirect()
          console.warn('Connection to API failed. Any request will be rejected and redirected to Login page.')
        } else {
          console.log('Successfully established connection to Actudent API.')
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
  window.location.href = conf.loginUrl()
}

export { 
  validateToken, 
  redirect, 
  bearerToken, 
  checkSubscription
}
