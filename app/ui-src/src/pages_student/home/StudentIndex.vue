<template>
  <div class="q-pa-md">
    <PresenceRecap />
    <TodaySchedule />
    <HomeworkInfo />
    <RecentAgenda url="/student/agenda" />
    <RecentPost />
    <ViewPost />
    <!-- <AccountChooser /> -->
  </div>
</template>

<script>
import PresenceRecap from './PresenceRecap.vue'
import TodaySchedule from './TodaySchedule.vue'
import HomeworkInfo from './HomeworkInfo.vue'
import RecentAgenda from 'src/pages_teacher/home/RecentAgenda.vue'
import RecentPost from './RecentPost.vue'
import ViewPost from 'src/pages/post/ViewPost.vue'
import AccountChooser from 'src/pages_student/switcher/AccountChooser.vue'
import { useLoginStore } from 'src/stores/login-store'

export default {
  name: 'StudentIndex',
  components: {
    PresenceRecap,
    TodaySchedule,
    HomeworkInfo,
    RecentAgenda,
    RecentPost,
    ViewPost,
    // AccountChooser,
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
