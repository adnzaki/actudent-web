<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">
        {{ `${$t('absensi_rekap_bulanan')} - ${$store.state.presence.className}` }}
      </div>
      <div class="text-h6 text-capitalize" v-else>
        {{ `${$t('absensi_rekap_bulanan')} - ${$store.state.presence.className}` }}
      </div>
      <div :class="['row q-mt-md', titleSpacing()]">
        <month-selector />
      </div>
    </q-card-section>
  </q-card>
</template>

<script>
import { useRoute } from 'vue-router'
import { useStore } from 'vuex'
import { titleSpacing } from 'src/composables/screen'
import MonthSelector from './MonthSelector.vue'

export default {
  name: 'SummoryMonth',
  components: {
    MonthSelector
    
  },
  setup() {
    
    const route = useRoute()
    const store = useStore()

    store.commit('presence/getClassName', route.params.id)
    store.state.presence.classID = route.params.id

    return {
      titleSpacing
    }
  }
}
</script>