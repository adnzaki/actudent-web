<template>
  <q-card class="q-mb-md">
    <q-card-section>
      <div class="text-h6 text-capitalize q-mb-md">
        {{ $t('home_presence_recap') }}
      </div>
      <div class="row q-mb-md q-col-gutter-sm">
        <div class="col-12 col-md-4">
          <recap-card
            :title="store.presenceInfo.message"
            :icon="presenceIcon(store.presenceInfo.status)"
            :color="presenceStatus(store.presenceInfo.status)"
          />
        </div>
        <div class="col-12 col-md-4">
          <recap-card
            :title="$t('home_monthly_percentage')"
            :number="store.presenceInfo.presence.monthlyPercentage"
            color="info"
          />
        </div>
        <div class="col-12 col-md-4">
          <recap-card
            :title="$t('home_period_percentage')"
            :number="store.presenceInfo.presence.periodPercentage"
            color="cyan"
          />
        </div>
      </div>
    </q-card-section>
  </q-card>
</template>

<script setup>
import RecapCard from './RecapCard.vue'
import { useMonitoringStore } from 'stores/monitoring'
import { onBeforeRouteLeave } from 'vue-router'

const store = useMonitoringStore()
store.getPresenceInfo()

const intervalId = setInterval(store.getPresenceInfo, 15000)
onBeforeRouteLeave(() => clearInterval(intervalId))

const presenceIcon = (status) => {
  const icons = {
    0: 'not_interested',
    1: 'verified',
    2: 'error_outline',
    3: 'health_and_safety',
    4: 'done',
    5: 'warning',
  }

  return icons[status]
}

const presenceStatus = (status) => {
  const colors = {
    0: 'red',
    1: 'green',
    2: 'orange',
    3: 'grey-8',
    4: 'teal',
    5: 'teal-8',
  }

  return colors[status]
}
</script>
