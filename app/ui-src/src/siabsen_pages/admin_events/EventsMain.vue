<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ $t('siabsen_kegiatan') }}</div>
      <div class="text-h6 text-capitalize" v-else>{{ $t('siabsen_kegiatan') }}</div>
      <div :class="['row', titleSpacing()]" style="margin-top: 0;">

      </div>
    </q-card-section>
    <month-selector class="q-pa-md" all-events />
    <events-list class="mobile-hide" />
    <events-list-mobile class="mobile-only" />
    <!-- content here -->
  </q-card>
</template>

<script>
import { provide } from 'vue'
import { useStore } from 'vuex'
import { useRouter } from 'vue-router'
import { titleSpacing } from 'src/composables/screen'
import MonthSelector from '../events/MonthSelector.vue';
import EventsList from './EventsList.vue';
import EventsListMobile from './EventsListMobile.vue';

export default {
  components: {
    MonthSelector,
    EventsList,
    EventsListMobile
  },
  setup() {
    const store = useStore()
    const router = useRouter()

    const goToAttendance = agendaId => {
      router.push('events/attendance/' + agendaId)
    }

    provide('goToAttendance', goToAttendance)
    
    return {
      titleSpacing
    }
  }
}
</script>