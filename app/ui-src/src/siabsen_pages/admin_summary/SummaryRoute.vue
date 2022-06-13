<template>
  <router-view />
</template>

<script>
import { wrapperPadding } from 'src/composables/screen'

export default {
  setup() {

    return { 
      wrapperPadding 
    }
  }
}
</script>
