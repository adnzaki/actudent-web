import { core } from 'boot/axios'
import { Cookies, conf } from 'src/composables/common'

// get token dynamically
const bearerToken = `Bearer ${Cookies.get(conf.cookieName)}`

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

function checkSubscription() {
  if(Cookies.has(conf.cookieName)) {
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
  } else {
    redirect()
  }
}

export { checkSubscription, bearerToken, redirect }