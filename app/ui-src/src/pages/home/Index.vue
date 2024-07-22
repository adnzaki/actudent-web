<template>
  <div class="q-pa-md">
    <total-daily-recap />
    <weekly-chart />
    <highest-lowest-presence />
    <presence-rank />
    <updates />
  </div>
</template>

<script>
import TotalDailyRecap from './TotalDailyRecap.vue'
import Updates from './Updates.vue'
import WeeklyChart from './WeeklyChart.vue'
import PresenceRank from './PresenceRank.vue'
import HighestLowestPresence from './HighestLowestPresence.vue'
export default {
  name: 'PageIndex',
  components: {
    Updates,
    TotalDailyRecap,
    WeeklyChart,
    PresenceRank,
    HighestLowestPresence,
  },
  beforeRouteEnter(to, from) {
    if (from.fullPath === '/login') {
      window.location.reload()
    }
  },
}
</script>
