<template>
  <div class="q-pa-md">    
    <presence-center />
    <presence-dialog />
    <today-schedule />
    <recent-agenda /> 
    <updates />
  </div>
</template>

<script>
import PresenceCenter from 'src/siabsen_pages/dashboard/PresenceCenter.vue'
import PresenceDialog from 'src/siabsen_pages/dashboard/PresenceDialog.vue'
import Updates from 'pages/home/Updates.vue'
import TodaySchedule from './TodaySchedule.vue'
import RecentAgenda from './RecentAgenda.vue'
export default {
  name: 'TeacherIndex',
  components: {
<<<<<<< HEAD
    PresenceCenter,
    PresenceDialog,
    Updates
=======
    Updates,
    TodaySchedule,
    RecentAgenda
>>>>>>> v2-dev
  },
  beforeRouteEnter(to, from) {
    if(from.fullPath === '/login') {
      window.location.reload()
    }
  }
}
</script>
