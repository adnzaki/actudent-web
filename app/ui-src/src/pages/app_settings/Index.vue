<template>
  <div :class="wrapperPadding()">    
    <language />
  </div>
</template>

<script>
import { wrapperPadding } from 'src/composables/screen'
import Language from './Language.vue'

export default {
  components: {
    Language
  },
  setup() {
    return {
      wrapperPadding
    }
  }
}
</script>
