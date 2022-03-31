<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ $t('absensi_title') }}</div>
      <div class="text-h6 text-capitalize" v-else>{{ $t('absensi_title') }}</div>
      <div :class="['row', titleSpacing()]">
        <div class="col-12 col-md-4"></div>
        <row-dropdown vuex-module="grade" class="q-mt-sm" />
        <search-box :label="$t('kelas_cari')" vuex-module="grade" class="q-mt-sm" />
      </div>
    </q-card-section>
    <class-table />
  </q-card>
</template>

<script>
import { useStore } from 'vuex'
import { titleSpacing } from 'src/composables/screen'
import ClassTable from './ClassTable.vue'

export default {
  name: 'PresenceClassList',
  components: {
    ClassTable    
  },
  setup () {   
    const store = useStore()
    store.state.presence.showSpinner = false
    
    return { 
      titleSpacing 
    }
  }
}
</script>
