<template>
  <q-card class="q-mb-md" v-if="$q.cookies.get(conf.userType) === '3'">
    <q-card-section>
      <div class="text-h6 text-capitalize q-mb-md">
        {{ $t('dashboard_today_schedule') }}
      </div>
      <q-list bordered separator v-if="store.todaySchedule.length > 0">
        <q-item
          clickable
          v-ripple
          v-for="(item, index) in store.todaySchedule"
          :key="index"
          to="/xxx"
        >
          <q-item-section v-if="item.lesson_code !== 'REST'">
            <q-item-label class="mobile-hide"
              >{{ item.lesson_name }} ({{ item.teacher }})</q-item-label
            >
            <q-item-label class="mobile-only"
              >{{ item.lesson_name }} <br />
              ({{ item.teacher }})</q-item-label
            >
            <q-item-label caption>
              {{ item.room_name }} - {{ item.duration }} JP
            </q-item-label>
          </q-item-section>

          <q-item-section v-else>
            <q-item-label>{{ item.lesson_name }}</q-item-label>
            <q-item-label caption>
              {{ item.duration }} {{ $t('jadwal_menit') }}
            </q-item-label>
          </q-item-section>

          <q-item-section side center>
            <q-badge
              color="teal"
              :label="`${item.schedule_start} - ${item.schedule_end}`"
            />
          </q-item-section>
        </q-item>
      </q-list>
      <p v-else>{{ $t('home_no_schedule') }}</p>
    </q-card-section>
  </q-card>
</template>

<style scoped>
.break-style {
  background-color: #cac4cdc8;
  color: #000;
}

.break-style .text-caption {
  color: #000;
}
</style>

<script setup>
import { conf } from 'src/composables/common'
import { useMonitoringStore } from 'src/stores/monitoring.js'

const store = useMonitoringStore()
store.getTodaySchedule()

const breakClass = (lessonCode) => (lessonCode === 'REST' ? 'break-style' : '')
</script>
