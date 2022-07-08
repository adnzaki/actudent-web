<template>
  <div :class="wrapperPadding()">    
    <language />
    <theme />
  </div>
</template>

<script>
import { wrapperPadding } from 'src/composables/screen'
import Language from './Language.vue'
import Theme from './Theme.vue'

export default {
  components: {
    Language,
    Theme
},
  setup() {
    return {
      wrapperPadding
    }
  }
}
</script>
