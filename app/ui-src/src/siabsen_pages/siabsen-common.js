import { Dark } from "quasar"
import { computed } from "vue"

const headerMobileList = computed(() => Dark.isActive ? 'bg-grey-8' : 'bg-primary')
const cardColor = computed(() => Dark.isActive ? 'bg-grey-9' : '')
const shadow = computed(() => (Dark.isActive ? '' : 'shadow-3'))
const textColor = computed(() => Dark.isActive ? 'text-white' : 'text-grey-8')

export {
  shadow,
  cardColor,
  textColor,
  headerMobileList
}