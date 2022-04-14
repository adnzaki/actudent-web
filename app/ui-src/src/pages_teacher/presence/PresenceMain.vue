<template>
  <div :class="wrapperPadding()"> 
    <router-view />
  </div>
</template>

<script>
import { wrapperPadding } from 'src/composables/screen'
import { useStore } from 'vuex'

export default {
  name: 'PresenceMain',
  setup() {
    const store = useStore()
    store.state.presence.isTeacherSection = true

    return { 
      wrapperPadding 
    }
  }
}
</script>
