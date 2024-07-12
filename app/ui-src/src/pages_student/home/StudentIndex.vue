<template>
  <div class="q-pa-md">
    <PresenceRecap />
    <TodaySchedule />
  </div>
</template>

<script>
import PresenceRecap from './PresenceRecap.vue'
import TodaySchedule from './TodaySchedule.vue'
export default {
  name: 'StudentIndex',
  components: {
    PresenceRecap,
    TodaySchedule,
  },
  beforeRouteEnter(to, from) {
    if (from.fullPath === '/login') {
      window.location.reload()
    }
  },
}
</script>
