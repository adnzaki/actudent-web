<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ $t('siabsen_kegiatan') }}</div>
      <div class="text-h6 text-capitalize" v-else>{{ $t('siabsen_kegiatan') }}</div>
      <div :class="['row', titleSpacing()]" style="margin-top: 0;">

      </div>
    </q-card-section>
    <agenda-form />
    <month-selector class="q-pa-md" all-events />
    <events-list class="mobile-hide" />
    <events-list-mobile class="mobile-only" />
    <!-- content here -->
  </q-card>
</template>

<script>
import { titleSpacing } from 'src/composables/screen'
import MonthSelector from '../events/MonthSelector.vue';
import EventsList from './EventsList.vue';
import AgendaForm from 'src/pages/agenda/AgendaForm.vue';
import EventsListMobile from './EventsListMobile.vue';

export default {
  components: {
    MonthSelector,
    EventsList,
    AgendaForm,
    EventsListMobile
  },
  setup() {
    
    return {
      titleSpacing
    }
  }
}
</script>