import { appConfig as conf } from '../../actudent.config'

const data = {
  greet: 'Hello!'
}

const funcs = { testGetData, testApi }

// admin token test
// const token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MSwiZW1haWwiOiJhZG1pbkB3b2xlc3RlY2guY29tIiwibmFtYSI6IkFkbmFuIFpha2kiLCJ1c2VyTGV2ZWwiOiIxIiwibG9nZ2VkX2luIjp0cnVlfQ.WP9JNv3p0pq_n8qA5YsZnofKcJwGREQORxmmrlSaM_k'

// teacher token test
const token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MSwiZW1haWwiOiJhZG1pbkB3b2xlc3RlY2guY29tIiwibmFtYSI6IkFkbmFuIFpha2kiLCJ1c2VyTGV2ZWwiOiIyIiwibG9nZ2VkX2luIjp0cnVlfQ.29W1VYj7lFgcebxq0AU8q2x2S5sYFihvTobStkSR6FM'

// const token = ''

function testApi () {
  fetch(`${conf.testAPI}token`, {
    method: 'GET',
    mode: 'cors',
    // credentials: 'include',
    headers: {
      // 'Content-type': 'application/json',
      Authorization: `Bearer ${token}`
    }
    // referrerPolicy: 'no-referrer'
  })
    .then(response => response.text())
    .then(data => {
      console.log('Success: ', data)
    })
    .catch((error) => {
      console.error('Error:', error)
    })
}

function testGetData () {
  fetch(`${conf.testAPI}get-data`, {
    method: 'GET',
    mode: 'cors',
    // credentials: 'include',
    headers: {
      // 'Content-type': 'application/json',
      Authorization: `Bearer ${token}`
    }
  })
    .then(response => response.json())
    .then(data => {
      console.log('Connection to API successfully')
      console.log(data)
    })
    .catch((error) => {
      console.error('Error:', error)
      // window.location.href = `${conf.adminAPI}login`
    })
}

export {
  data,
  funcs
}
