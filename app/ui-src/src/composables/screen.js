import { Screen } from 'quasar'

const menuWidth = () => {
  return Screen.lt.sm
    ? 300
    : 230
}

const wrapperPadding = () => {
  return Screen.lt.sm
    ? ''
    : 'q-pa-md'
}

const checkColWidth = () => {
  return Screen.lt.sm
    ? 'decrease-col-size'
    : ''
}

const maximizedDialog = () => {
  return Screen.lt.sm ? true : false
}

const cardDialog = () => {
  return Screen.lt.sm
    ? { height: '100vh' }
    : { width: '700px', maxWidth: '80vw' }
}

const cardSection = () => {
  return Screen.lt.sm
    ? { maxHeight: '100vh' }
    : { maxHeight: '60vh' }
}

const justifyDataOptions = () => {
  return Screen.lt.sm
    ? { paddingRight: '0' }
    : { paddingRight: '10px' }
}

export { 
  maximizedDialog, cardDialog, cardSection, 
  justifyDataOptions, checkColWidth, wrapperPadding,
  menuWidth
}