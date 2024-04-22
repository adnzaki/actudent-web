import { Dark, Cookies } from 'quasar'
import { ref } from 'vue'

const headerColor = ref('')
const actionButton = ref(['action-btn'])
const addButton = ref(['add-btn'])
const saveButton = ref('save-btn')
const fabColor = ref('primary')
const header = ref('')
const elevated = ref(true)
const userMenu = ref(['user-menu'])

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

function triggerHeader() {
  if (headerColor.value === 'dark') {
    header.value = 'bg-grey-10'
    elevated.value = false
    userMenu.value.push('user-menu-dark')
  } else {
    header.value = 'header-gradient'
    elevated.value = true
    userMenu.value.pop()
  }
}

function triggerMode() {
  if (Cookies.get('theme') === 'dark') {
    Dark.toggle()
    toggleHeader()
  }
}

export {
  headerColor,
  toggleHeader,
  triggerMode,
  actionButton,
  addButton,
  fabColor,
  triggerHeader,
  header,
  elevated,
  userMenu,
}
