<template>
  <div class="q-pa-md">
    <presence-flash-recap />
    <total-daily-recap />
    <weekly-chart />
    <highest-lowest-presence />
    <presence-rank />
    <updates />
  </div>
</template>

<script>
import PresenceFlashRecap from 'src/siabsen_pages/dashboard/PresenceFlashRecap.vue'
import TotalDailyRecap from './TotalDailyRecap.vue'
import Updates from './Updates.vue'
import WeeklyChart from './WeeklyChart.vue'
import PresenceRank from './PresenceRank.vue'
import HighestLowestPresence from './HighestLowestPresence.vue'
import { useLoginStore } from 'src/stores/login-store'
export default {
  name: 'PageIndex',
  components: {
    PresenceFlashRecap,
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
  setup() {
    const store = useLoginStore()

    store.updateDb()
  },
}
</script>
