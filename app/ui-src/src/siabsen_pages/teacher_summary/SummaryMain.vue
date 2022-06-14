<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ $t('siabsen_detail_absensi') }}</div>
      <div class="text-h6 text-capitalize" v-else>{{ $t('siabsen_detail_absensi') }}</div>
      <div :class="['row', titleSpacing()]" style="margin-top: 0;">
        <period-selector />
      </div>
    </q-card-section>
    <div class="row q-mb-lg"></div>
    <presence-detail-table />
  </q-card>
</template>

<script>
import { useStore } from 'vuex'
import { titleSpacing } from 'src/composables/screen'
import PeriodSelector from './PeriodSelector.vue'
import PresenceDetailTable from '../admin_summary/PresenceDetailTable.vue'

export default {
  components: {
    PeriodSelector,
    PresenceDetailTable,
  },
  setup() {
    const store = useStore();
    return {
        titleSpacing
    }
  },  
}
</script>
