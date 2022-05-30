<template>
  <div :class="wrapperPadding()">  
    <router-view />
  </div>
</template>

<script>
import { wrapperPadding } from 'src/composables/screen'

export default {
  name: 'Index',
  setup() {

    return { 
      wrapperPadding 
    }
  }
}
</script>
