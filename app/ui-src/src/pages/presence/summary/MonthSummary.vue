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
          {{ $t('absensi_rekap_bulanan') }}
        </div>
        <div class="text-h6 text-capitalize" v-else>
          {{ `${$t('absensi_rekap_bulanan')} - ${store.className}` }}
        </div>
      </div>
      <div :class="['row q-mt-md', titleSpacing()]">
        <month-selector />
      </div>
    </q-card-section>
    <div class="q-pa-md summary-spinner" v-if="store.showSpinner">
      <q-spinner-bars color="purple" size="xl" />
    </div>
    <month-table />
  </q-card>
</template>

<script>
import { useQuasar } from 'quasar'
import { useRoute } from 'vue-router'
import { titleSpacing } from 'src/composables/screen'
import { usePresenceStore } from 'src/stores/presence'
import MonthTable from './MonthTable.vue'
import MonthSelector from './MonthSelector.vue'

export default {
  name: 'MonthSummary',
  components: {
    MonthTable,    
    MonthSelector,
  },
  setup() {
    const $q = useQuasar()
    const route = useRoute()
    const store = usePresenceStore()

    store.getClassName(route.params.id)
    store.classID = route.params.id
    store.showMonthTable = false
    store.monthlySummary = {}

    return { 
      store,
      titleSpacing,
      pushLeft: $q.screen.lt.sm ? '' : 'page-title-pl-5',
      showBackBtn: localStorage.getItem('grade_id') === null ? true : false,
    }
  }
}
</script>