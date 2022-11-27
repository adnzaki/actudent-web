<template>
  <div class="q-pa-md">  
    <presence-flash-recap />   
    <total-daily-recap />
    <weekly-chart />
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
export default {
  name: 'PageIndex',
  components: {
    PresenceFlashRecap,
    Updates,
    TotalDailyRecap,
    WeeklyChart,
    PresenceRank
  },
  beforeRouteEnter(to, from) {
    if(from.fullPath === '/login') {
      window.location.reload()
    }
  }
}
</script>
