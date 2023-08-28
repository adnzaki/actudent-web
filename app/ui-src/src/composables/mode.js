import { Dark, Cookies } from 'quasar'
import { ref } from 'vue'

let headerColor = ref('')
const actionButton = ref(['action-btn'])
const addButton = ref(['add-btn'])
const saveButton = ref('save-btn')
const fabColor = ref('primary')

const toggleHeader = () => {
  if (Dark.isActive) {
    headerColor.value = 'dark'
    actionButton.value.push('action-btn-dark')
    addButton.value.push('add-btn-dark')
    fabColor.value = 'grey-8'
  } else {
    headerColor.value = 'light'
    actionButton.value.pop()
    addButton.value.pop()
    fabColor.value = 'secondary'
  }

}

function triggerMode() {
  if (Cookies.get('theme') === 'dark') {
    Dark.toggle()
    toggleHeader()
  }
}

export { headerColor, toggleHeader, triggerMode, actionButton, addButton, fabColor }
