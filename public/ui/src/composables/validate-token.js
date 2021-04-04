import { appConfig as conf } from '../../actudent.config'

function validateToken (validator) {
  fetch(`${conf.coreAPI}validate-token/${validator}`, {
    method: 'GET',
    mode: 'cors',
    headers: {
      Authorization: `Bearer ${conf.testToken}`
    }
  })
    .then(response => response.json())
    .then(data => {
      if (data.status === 503) {
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
}

function redirect (validator) {
  if (validator === 'is_admin') {
    window.location.href = `${conf.adminAPI}login`
  } else {
    window.location.href = `${conf.teacherAPI}login`
  }
}

export { validateToken, redirect }
