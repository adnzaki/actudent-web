<template>
  <div :class="wrapperPadding()">
    <router-view />
  </div>
</template>

<script>
import { wrapperPadding } from 'src/composables/screen'

export default {
  name: 'IndexPage',
  setup() {
    return {
      wrapperPadding,
    }
  },
}
</script>
