<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ $t('siabsen_kegiatan') }}</div>
      <div class="text-h6 text-capitalize" v-else>{{ $t('siabsen_kegiatan') }}</div>
      <div :class="['row', titleSpacing()]" style="margin-top: 0;">

      </div>
    </q-card-section>
    <agenda-form />
    <month-selector class="q-pa-md" />
    <events-list />
    <!-- content here -->
  </q-card>
</template>

<script>
import { titleSpacing } from 'src/composables/screen'
import MonthSelector from './MonthSelector.vue'
import EventsList from './EventsList.vue'
import AgendaForm from 'src/pages/agenda/AgendaForm.vue'

export default {
  components: {
    MonthSelector,
    EventsList,
    AgendaForm
},
  setup() {
    return {
      titleSpacing
    }
  }
}
</script>