<template>
  <q-card class="q-mb-md">
    <q-card-section>
      <div class="text-h6 text-capitalize q-mb-md">{{ $t('dashboard_agenda_title') }}</div>
      <q-list bordered separator v-if="events.length > 0">
        <q-item clickable v-ripple v-for="(item, index) in events" :key="index" to="/teacher/agenda">
          <q-item-section>
            <q-item-label>{{ item.title }}</q-item-label>
            <q-item-label caption>
              {{ item.startStr }}
            </q-item-label>
          </q-item-section>
          <q-item-section side center>
            <q-badge :color="badgeColor(item.priority)" :label="priority(item.priority)" />
          </q-item-section>
        </q-item>
      </q-list>
      <p v-else>{{ $t('dashboard_agenda_empty') }}</p>
    </q-card-section>
  </q-card>
</template>

<script>
import { date } from 'quasar'
import { computed } from 'vue'
import { t } from 'src/composables/common'
import { useAgendaStore } from 'src/stores/agenda'

export default {
  setup() {
    const store = useAgendaStore()

    const formatDate = v => date.formatDate(v, 'YYYY-MM-DD')

    const defaultStart = date.startOfDate(new Date(), 'month')    
    const defaultStartDate = date.subtractFromDate(defaultStart, { days: 7 })
    const defaultEnd = date.addToDate(defaultStart, { days: 14, months: 1 })

    store.getEvents({
      view: '',
      start: formatDate(defaultStartDate),
      end: formatDate(defaultEnd)
    })       

    return {
      priority(priority) {
        const text = {
          low: t('agenda_input_lowprior'),
          normal: t('agenda_input_normalprior'),
          high: t('agenda_input_highprior')
        }

        return text[ priority ]
      },
      badgeColor(priority) {
        const colors = {
          low: 'secondary',
          normal: 'primary',
          high: 'red'
        }

        return colors[ priority ]
      },
      events: computed(() => store.events)
    } 
  }
}
</script>