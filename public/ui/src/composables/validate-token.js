import { appConfig as conf } from '../../actudent.config'

export default function validateToken (validator) {
  // const token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MSwiZW1haWwiOiJhZG1pbkB3b2xlc3RlY2guY29tIiwibmFtYSI6IkFkbmFuIFpha2kiLCJ1c2VyTGV2ZWwiOiIxIiwibG9nZ2VkX2luIjp0cnVlfQ.WP9JNv3p0pq_n8qA5YsZnofKcJwGREQORxmmrlSaM_k'
  const token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MSwiZW1haWwiOiJhZG1pbkB3b2xlc3RlY2guY29tIiwibmFtYSI6IkFkbmFuIFpha2kiLCJ1c2VyTGV2ZWwiOiIyIiwibG9nZ2VkX2luIjp0cnVlfQ.29W1VYj7lFgcebxq0AU8q2x2S5sYFihvTobStkSR6FM'
  fetch(`${conf.coreAPI}validate-token/${validator}`, {
    method: 'GET',
    mode: 'cors',
    headers: {
      Authorization: `Bearer ${token}`
    }
  })
    .then(response => response.json())
    .then(data => {
      if (data.status === 500) {
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
