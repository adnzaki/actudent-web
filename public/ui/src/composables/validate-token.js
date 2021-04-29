import { appConfig as conf } from '../../actudent.config'
import { core } from 'boot/axios'
import { Cookies } from 'quasar'

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
          redirect(validator)
          console.warn('Connection to API failed. Any request will be rejected and redirected to Login page.')
        } else {
          console.log('Successfully established connection to Actudent API.')
        }
      })
      .catch((error) => {
        console.error('Error:', error)
        redirect(validator)
      })
  } else {
    redirect(validator)
  }
}

function redirect (validator) {
  if (validator === 'is_admin') {
    window.location.href = `${conf.adminAPI}login`
  } else {
    window.location.href = `${conf.teacherAPI}login`
  }
}

export { validateToken, redirect, bearerToken }
