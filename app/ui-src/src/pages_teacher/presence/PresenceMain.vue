<template>
  <div :class="wrapperPadding()"> 
    <router-view />
  </div>
</template>

<script>
import { wrapperPadding } from 'src/composables/screen'
import { usePresenceStore } from 'src/stores/presence'

export default {
  name: 'PresenceMain',
  setup() {
    const store = usePresenceStore()
    store.isTeacherSection = true

    return { 
      wrapperPadding 
    }
  }
}
</script>
