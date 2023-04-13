<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="row">
        <q-btn color="teal" flat rounded
          class="back-button"
          icon="arrow_back" 
          v-if="showBackBtn"
          @click="$router.push('/presence')" />
        <div :class="['text-subtitle1 text-uppercase q-mt-xs', pushLeft]" v-if="$q.screen.lt.sm">
          {{ $t('absensi_rekap_semester') }}
        </div>
        <div class="text-h6 text-capitalize" v-else>
          {{ `${$t('absensi_rekap_semester')} - ${store.className}` }}
        </div>
      </div>
      <div :class="['row q-mt-md', titleSpacing()]">
        <period-selector />
      </div>
    </q-card-section>
    <period-table />
    <div class="q-pa-md summary-spinner" v-if="store.showSpinner">
      <q-spinner-bars color="purple" size="xl" />
    </div>
    <div class="q-pl-lg q-py-sm">
      <p class="text-bold" v-if="store.showNoData">{{ $t('no_data') }}</p>
    </div>
  </q-card>
</template>

<script>
import { useQuasar } from 'quasar'
import { useRoute } from 'vue-router'
import PeriodTable from './PeriodTable.vue'
import PeriodSelector from './PeriodSelector.vue'
import { titleSpacing } from 'src/composables/screen'
import { usePresenceStore } from 'src/stores/presence'

export default {
  name: 'PeriodSummary',
  components: {
    PeriodTable,
    PeriodSelector,
  },
  setup() {
    const $q = useQuasar()
    const route = useRoute()
    const store = usePresenceStore()

    store.getClassName(route.params.id)
    store.classID = route.params.id
    store.periodSummary = {}

    return { 
      store,
      titleSpacing,
      pushLeft: $q.screen.lt.sm ? '' : 'page-title-pl-5',
      showBackBtn: localStorage.getItem('grade_id') === null ? true : false,
    }
  }
}
</script>