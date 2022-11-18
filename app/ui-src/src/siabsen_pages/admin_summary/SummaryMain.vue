<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ $t('siabsen_rekap_periodik') }}</div>
      <div class="text-h6 text-capitalize" v-else>{{ $t('siabsen_rekap_periodik') }}</div>
      <div :class="['row', titleSpacing()]" style="margin-top: 0;">
        <period-selector />
        <search-box :label="$t('siabsen_cari_guru')" root-class="col-12 col-md-3 offset-md-1" vuex-module="siabsen" class="q-mt-md" />
      </div>
    </q-card-section>
    <q-scroll-area class="table-scroll-area mobile-hide">
      <summary-table />
    </q-scroll-area>
    <summary-table class="mobile-only" />
    <q-separator/>
    <ss-paging vuex-module="siabsen" />
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
