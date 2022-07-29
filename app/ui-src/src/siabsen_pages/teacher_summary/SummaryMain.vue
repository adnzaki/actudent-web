<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ $t('absensi_rekap_bulanan') }}</div>
      <div class="text-h6 text-capitalize" v-else>{{ $t('absensi_rekap_bulanan') }}</div>
      <div :class="['row q-mb-md', titleSpacing()]" style="margin-top: 0;">
        <period-selector />
      </div>
    </q-card-section>
    <div class="row mobile-hide">
      <div class="col-6">
        <presence-note-mobile bg-color="bg-blue" />
      </div>
      <div class="col-6">
        <time-recap-mobile bg-color="bg-deep-orange" />
      </div>
    </div>
    <presence-detail-table class="q-mt-md q-mb-xl"  />
    <presence-detail-mobile />
  </q-card>
</template>

<script>
import { computed, provide } from 'vue'
import { useStore } from 'vuex'
import { titleSpacing } from 'src/composables/screen'
import PeriodSelector from './PeriodSelector.vue'
import PresenceDetailTable from '../admin_summary/PresenceDetailTable.vue'
import PresenceNoteMobile from '../admin_summary/PresenceNoteMobile.vue'
import TimeRecapMobile from '../admin_summary/TimeRecapMobile.vue'
import PresenceDetailMobile from '../admin_summary/PresenceDetailMobile.vue'

export default {
  components: {
    PeriodSelector,
    PresenceDetailTable,
    PresenceNoteMobile,
    TimeRecapMobile,
    PresenceDetailMobile
},
  setup() {
    const store = useStore()

    const presenceDetail = computed(() => store.state.siabsen.presenceDetail)
    provide('presenceDetail', presenceDetail)

    return {
        titleSpacing
    }
  },  
}
</script>
