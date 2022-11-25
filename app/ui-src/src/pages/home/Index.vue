<template>
  <div class="q-pa-md">  
    <presence-flash-recap />   
    <total-daily-recap />
    <updates />
  </div>
</template>

<script>
import PresenceFlashRecap from 'src/siabsen_pages/dashboard/PresenceFlashRecap.vue'
import TotalDailyRecap from './TotalDailyRecap.vue'
import Updates from './Updates.vue'
export default {
  name: 'PageIndex',
  components: {
    PresenceFlashRecap,
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
