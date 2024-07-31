<template>
  <div v-if="store.showMonthlyPresence && data.length > 0" class="q-pa-md">
    <q-expansion-item
      class="shadow-1 overflow-hidden q-mb-md"
      style="border-radius: 15px"
      icon="event"
      :label="item.date_long"
      :header-class="[headerMobileList, 'text-white']"
      expand-icon-class="text-white"
      default-opened
      v-for="(item, index) in data"
      :key="index"
    >
      <q-card>
        <q-card-section>
          <p v-if="item.status !== 4">
            Status:
            <q-badge
              :color="badgeColor[item.status]"
              :label="item.status_text"
            />
          </p>
          <p v-else>{{ item.status_text }}</p>
          <q-list bordered separator v-if="item.detail.length > 0">
            <q-item v-for="(val, key) in item.detail" :key="key">
              <q-item-section>
                <q-item-label>{{ val.journal.lesson_name }}</q-item-label>
                <q-item-label caption>
                  {{ val.journal.description }}
                </q-item-label>
              </q-item-section>
              <q-item-section side center>
                <q-badge
                  :color="badgeColor[parseInt(val.status)]"
                  :label="val.status_text"
                />
              </q-item-section>
            </q-item>
          </q-list>
        </q-card-section>
      </q-card>
    </q-expansion-item>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useMonitoringStore } from 'src/stores/monitoring.js'
import { headerMobileList } from 'src/composables/siabsen-mode'

const store = useMonitoringStore()

const data = computed(() => store.monthlyPresence)
const badgeColor = ref(['negative', 'green', 'orange', 'teal', 'grey-8'])
</script>
