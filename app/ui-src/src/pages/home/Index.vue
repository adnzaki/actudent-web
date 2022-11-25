<template>
  <div class="q-pa-md">    
    <total-daily-recap />
    <weekly-chart />
    <updates />
  </div>
</template>

<script>
import TotalDailyRecap from './TotalDailyRecap.vue'
import Updates from './Updates.vue'
import WeeklyChart from './WeeklyChart.vue'
export default {
  name: 'PageIndex',
  components: {
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
