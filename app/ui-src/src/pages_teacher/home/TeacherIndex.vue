<template>
  <div class="q-pa-md">
    <today-schedule />
    <recent-agenda />
    <updates />
  </div>
</template>

<script>
import Updates from 'pages/home/Updates.vue'
import TodaySchedule from './TodaySchedule.vue'
import RecentAgenda from './RecentAgenda.vue'
import { useLoginStore } from 'src/stores/login-store'
export default {
  name: 'TeacherIndex',
  components: {
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
