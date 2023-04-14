import { appConfig as conf } from '../../actudent.config'
import { core } from 'boot/axios'
import { Cookies } from 'quasar'
import { runLoadingBar } from 'src/composables/common'
import { checkSubscription, bearerToken, redirect } from 'src/composables/subscription'

function validateToken(validator, teacherReport) {
  runLoadingBar()
  if (Cookies.has(conf.cookieName)) {
    core.get(`validate-token/${validator}`, {
      headers: {
        Authorization: bearerToken
      }
    })
      .then(({ data }) => {
        if (data.status === 503) {
          redirect()
          console.warn('[Actudent] Connection to API failed. Any request will be rejected and redirected to Login page.')
        } else {
          console.info('[Actudent] Successfully established connection to Actudent API.')
          if (teacherReport && data.check === 0) {
            window.location.href = conf.teacherHomeUrl()
          }

          localStorage.setItem(conf.userLang, data.lang)
          console.info('[Actudent] App language synced. Need a full reload to take effect')
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


function routeValidator(type = 'is_admin', teacherReport = false) {
  checkSubscription()
  validateToken(type, teacherReport)
}

export {
  redirect,
  bearerToken,
  validateToken,
  routeValidator,
}
