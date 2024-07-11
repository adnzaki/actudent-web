<template>
  <div class="q-pa-md">
    <PresenceRecap />
  </div>
</template>

<script>
import PresenceRecap from './PresenceRecap.vue'
export default {
  name: 'StudentIndex',
  components: {
    PresenceRecap,
  },
  beforeRouteEnter(to, from) {
    if (from.fullPath === '/login') {
      window.location.reload()
    }
  },
}
</script>
