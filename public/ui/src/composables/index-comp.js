import { appConfig as conf } from '../../actudent.config'

const data = {
  greet: 'Hellooooo!'
}

const methods = { testGetData }

function testGetData () {
  fetch(`${conf.testAPI}get-data`, {
    method: 'GET',
    mode: 'cors',
    // credentials: 'include',
    headers: {
      // 'Content-type': 'application/json',
      Authorization: `Bearer ${conf.testToken}`
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
  methods
}
