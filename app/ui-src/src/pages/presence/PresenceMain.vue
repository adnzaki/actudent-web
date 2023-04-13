<template>
  <div :class="wrapperPadding()">  
    <router-view />
  </div>
</template>

<script>
import { usePresenceStore } from 'src/stores/presence'
import { wrapperPadding } from 'src/composables/screen'

export default {
  name: 'PresenceMain',
  setup() {
    const store = usePresenceStore()
    store.isTeacherSection = false

    return {
      wrapperPadding 
    }
  }
}
</script>
