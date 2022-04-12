<template>
  <div :class="wrapperPadding()"> 
    <router-view />
  </div>
</template>

<script>
import { wrapperPadding } from 'src/composables/screen'

export default {
  name: 'PresenceMain',
  setup() {
    console.log('Page loaded')
    return { 
      wrapperPadding 
    }
  }
}
</script>
