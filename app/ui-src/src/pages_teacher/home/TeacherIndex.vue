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
import { useLoginStore } from 'src/stores/login-store'
export default {
  name: 'TeacherIndex',
  components: {
    PresenceCenter,
    PresenceDialog,
    Updates,
    TodaySchedule,
    RecentAgenda,
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
