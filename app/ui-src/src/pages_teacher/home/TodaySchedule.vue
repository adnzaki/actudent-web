<template>
  <q-card class="q-mb-md" v-if="$q.cookies.get(conf.userType) === '2'">
    <q-card-section>
      <div class="text-h6 text-capitalize q-mb-md">{{ $t('dashboard_today_schedule') }}</div>
      <q-list bordered separator v-if="schedules.length > 0">
        <q-item clickable v-ripple v-for="(item, index) in schedules" :key="index" to="/teacher/presence">
          <q-item-section>
            <q-item-label>{{ item.grade_name }}: {{ item.lesson_name }}</q-item-label>
            <q-item-label caption>
              {{ item.room_name }} - {{ item.duration }} JP
            </q-item-label>
          </q-item-section>
          <q-item-section side center>
            <q-badge color="teal" :label="`${item.schedule_start} - ${item.schedule_end}`" />
          </q-item-section>
        </q-item>
      </q-list>
      <p v-else>{{ $t('dashboard_no_schedule') }}</p>
    </q-card-section>
  </q-card>
</template>

<script>
import { onMounted, computed } from 'vue'
import { conf } from 'src/composables/common'
import { usePresenceStore } from 'src/stores/presence'

export default {
  setup() {
    const store = usePresenceStore()
    const getDay = new Date().getDay()
    store.helper.activeDay = getDay

    onMounted(() => {
      setTimeout(() => store.getTeacherSchedules(), 500)
    })

    return {
      conf,
      schedules: computed(() => store.teacherSchedules)
    } 
  }
}
</script>