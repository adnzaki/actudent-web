<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="row">
        <q-btn color="teal" flat rounded
          class="back-button"
          icon="arrow_back" 
          @click="$router.push('/presence')" />
        <div class="text-subtitle1 text-uppercase q-mt-xs" style="margin-left: -5px;" v-if="$q.screen.lt.sm">
          {{ `${$t('absensi_rekap_bulanan')} - ${$store.state.presence.className}` }}
        </div>
        <div class="text-h6 text-capitalize" v-else>
          {{ `${$t('absensi_rekap_bulanan')} - ${$store.state.presence.className}` }}
        </div>
      </div>
      <div :class="['row q-mt-md', titleSpacing()]">
        <month-selector />
      </div>
    </q-card-section>
    <div class="q-pa-md summary-spinner" v-if="$store.state.presence.showSpinner">
      <q-spinner-bars color="purple" size="xl" />
    </div>
    <month-table />
  </q-card>
</template>

<script>
import { useRoute } from 'vue-router'
import { useStore } from 'vuex'
import { titleSpacing } from 'src/composables/screen'
import MonthSelector from './MonthSelector.vue'
import MonthTable from './MonthTable.vue'

export default {
  name: 'MonthSummory',
  components: {
    MonthSelector,
    MonthTable    
  },
  setup() {
    
    const route = useRoute()
    const store = useStore()

    store.commit('presence/getClassName', route.params.id)
    store.state.presence.classID = route.params.id
    store.state.presence.showMonthTable = false
    store.state.presence.monthlySummary = {}

    return {
      titleSpacing
    }
  }
}
</script>