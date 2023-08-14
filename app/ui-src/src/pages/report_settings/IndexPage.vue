<template>
  <div :class="wrapperPadding()">
    <LetterheadImage />
  </div>
</template>

<script>
import { wrapperPadding } from 'src/composables/screen'
import LetterheadImage from './LetterheadImage.vue'

export default {
  components: { LetterheadImage },
  setup() {
    return {
      wrapperPadding,
    }
  },
}
</script>
