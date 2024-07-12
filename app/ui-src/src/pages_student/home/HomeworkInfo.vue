<template>
  <q-card class="q-mb-md" v-if="$q.cookies.get(conf.userType) === '3'">
    <q-card-section>
      <div class="text-h6 text-capitalize q-mb-md">
        {{ $t('home_tugas_rumah') }}
      </div>
      <q-list bordered separator v-if="store.homework.length > 0">
        <q-item
          clickable
          v-ripple
          v-for="(item, index) in store.homework"
          :key="index"
          to="/xxx"
        >
          <q-item-section>
            <q-item-label class="mobile-hide"
              >{{ item.homework_title }} ({{ item.lesson_name }})</q-item-label
            >
            <q-item-label class="mobile-only"
              >{{ item.homework_title }} <br />
              ({{ item.lesson_name }})</q-item-label
            >
            <q-item-label caption>
              {{ item.homework_description }}
            </q-item-label>
          </q-item-section>

          <q-item-section side center>
            <q-badge class="mobile-hide" color="teal" :label="item.due_date" />
            <q-badge
              class="mobile-only"
              color="teal"
              :label="item.due_date_short"
            />
          </q-item-section>
        </q-item>
      </q-list>
      <p v-else>{{ $t('home_no_homework') }}</p>
    </q-card-section>
  </q-card>
</template>

<script setup>
import { conf } from 'src/composables/common'
import { useMonitoringStore } from 'src/stores/monitoring.js'

const store = useMonitoringStore()
store.getHomework()
</script>
