<template>
  <div :class="wrapperPadding()">  
    <router-view />
  </div>
</template>

<script>
import { wrapperPadding } from 'src/composables/screen'

export default {
  name: 'ClassMain',
  setup() {
    return { 
      wrapperPadding 
    }
  }
}
</script>
