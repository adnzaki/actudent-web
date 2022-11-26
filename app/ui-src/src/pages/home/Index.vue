<template>
  <div class="q-pa-md">  
    <presence-flash-recap />   
    <total-daily-recap />
    <weekly-chart />
    <updates />
  </div>
</template>

<script>
import PresenceFlashRecap from 'src/siabsen_pages/dashboard/PresenceFlashRecap.vue'
import TotalDailyRecap from './TotalDailyRecap.vue'
import Updates from './Updates.vue'
import WeeklyChart from './WeeklyChart.vue'
export default {
  name: 'PageIndex',
  components: {
    PresenceFlashRecap,
    Updates,
    TotalDailyRecap,
    WeeklyChart
  },
  beforeRouteEnter(to, from) {
    if(from.fullPath === '/login') {
      window.location.reload()
    }
  }
}
</script>
