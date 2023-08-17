<template>
  <div :class="wrapperPadding()">
    <ChangePassword />
  </div>
</template>

<script>
import { wrapperPadding } from 'src/composables/screen'
import ChangePassword from './ChangePassword.vue'

export default {
  components: { ChangePassword },
  setup() {
    return {
      wrapperPadding,
    }
  },
}
</script>
