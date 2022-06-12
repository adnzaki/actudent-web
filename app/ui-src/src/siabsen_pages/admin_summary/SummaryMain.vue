<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ $t('absensi_rekap_bulanan') }}</div>
      <div class="text-h6 text-capitalize" v-else>{{ $t('absensi_rekap_bulanan') }}</div>
      <div :class="['row', titleSpacing()]" style="margin-top: 0;">
        <period-selector />
        <search-box :label="$t('siabsen_cari_guru')" root-class="col-12 col-md-4 offset-md-2" vuex-module="siabsen" class="q-mt-md" />
      </div>
    </q-card-section>
    <summary-table />
  </q-card>
</template>

<script>
import { useStore } from 'vuex'
import { titleSpacing } from 'src/composables/screen'
import PeriodSelector from './PeriodSelector.vue'
import SummaryTable from './SummaryTable.vue'

export default {
  components: {
    PeriodSelector,
    SummaryTable
  },
  setup() {
    const store = useStore();
    return {
        titleSpacing
    }
  },  
}
</script>
