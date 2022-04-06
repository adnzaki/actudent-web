import { Dark, Cookies } from 'quasar'
import { ref } from 'vue'

let headerColor = ref('')

const toggleHeader = () => {
  Dark.isActive ? headerColor.value = 'dark' : headerColor.value = 'light'
  console.log(headerColor.value)
}

function triggerMode() {
  if(Cookies.get('theme') === 'dark') {
    Dark.toggle()
    toggleHeader()
  }
}

export { headerColor, toggleHeader, triggerMode }
