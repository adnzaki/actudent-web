import { Screen } from 'quasar'

const maximizedDialog = () => {
  return Screen.lt.sm ? true : false
}

const cardDialog = () => {
  let style
  return Screen.lt.sm
    ? style = { height: '100vh' }
    : style = { width: '700px', maxWidth: '80vw' }
}

const cardSection = () => {
  let style
  return Screen.lt.sm
    ? style = { maxHeight: '100vh' }
    : style = { maxHeight: '60vh' }
}

export { maximizedDialog, cardDialog, cardSection }