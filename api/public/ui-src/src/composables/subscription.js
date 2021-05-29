import { core } from 'boot/axios'
import { redirect, bearerToken } from './validate-token'

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

export { checkSubscription }
