import { appConfig as conf } from '../../actudent.config'
import { core } from 'boot/axios'
import { Cookies } from 'quasar'
import { mode } from '../../globalConfig'

// get token dynamically
const bearerToken = `Bearer ${Cookies.get(conf.cookieName)}`

function validateToken (validator) {
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
  if(mode === 'production') {
    window.location.href = `${conf.uiPath()}login.html`
  } else {
    window.location.href = `${conf.host()}actudent/login.html`
  }
}

export { 
  validateToken, 
  redirect, 
  bearerToken, 
}
