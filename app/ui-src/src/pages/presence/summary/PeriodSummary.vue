<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="row">
        <q-btn color="teal" flat rounded
          class="back-button"
          icon="arrow_back" 
          @click="$router.push('/presence')" />
        <div class="text-subtitle1 text-uppercase q-mt-xs page-title-pl-5" v-if="$q.screen.lt.sm">
          {{ $t('absensi_rekap_semester') }}
        </div>
        <div class="text-h6 text-capitalize" v-else>
          {{ `${$t('absensi_rekap_semester')} - ${$store.state.presence.className}` }}
        </div>
      </div>
      <div :class="['row q-mt-md', titleSpacing()]">
        <period-selector />
      </div>
    </q-card-section>
    <period-table />
    <div class="q-pa-md summary-spinner" v-if="$store.state.presence.showSpinner">
      <q-spinner-bars color="purple" size="xl" />
    </div>
    <div class="q-pl-lg q-py-sm">
      <p class="text-bold" v-if="$store.state.presence.showNoData">{{ $t('no_data') }}</p>
    </div>
  </q-card>
</template>

<script>
import { useRoute } from 'vue-router'
import { useStore } from 'vuex'
import { titleSpacing } from 'src/composables/screen'
import PeriodSelector from './PeriodSelector.vue'
import PeriodTable from './PeriodTable.vue'

export default {
  name: 'PeriodSummary',
  components: {
    PeriodSelector,
    PeriodTable
  },
  setup() {
    
    const route = useRoute()
    const store = useStore()

    store.commit('presence/getClassName', route.params.id)
    store.state.presence.classID = route.params.id
    store.state.presence.periodSummary = {}

    return {
      titleSpacing
    }
  }
}
</script>