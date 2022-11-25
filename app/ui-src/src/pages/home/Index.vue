<template>
  <div class="q-pa-md">    
    <total-daily-recap />
    <updates />
  </div>
</template>

<script>
import TotalDailyRecap from './TotalDailyRecap.vue'
import Updates from './Updates.vue'
export default {
  name: 'PageIndex',
  components: {
    Updates,
    TotalDailyRecap
  },
  beforeRouteEnter(to, from) {
    if(from.fullPath === '/login') {
      window.location.reload()
    }
  }
}
</script>
