<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ $t('absensi_title') }}</div>
      <div class="text-h6 text-capitalize" v-else>{{ $t('absensi_title') }}</div>
      <div :class="['row', titleSpacing()]">
        <div class="col-12 col-md-4"></div>
        <row-dropdown class="q-mt-sm" />
        <search-box :label="$t('kelas_cari')" class="q-mt-sm" />
      </div>
    </q-card-section>

    <class-table />
    
  </q-card>
</template>

<script>
import ClassTable from './ClassTable.vue'
import { titleSpacing } from 'src/composables/screen'
import { usePresenceStore } from 'src/stores/presence'

export default {
  name: 'PresenceClassList',
  components: {
    ClassTable    
  },
  setup () {   
    const store = usePresenceStore()
    store.showSpinner = false
    
    return { 
      store, 
      titleSpacing 
    }
  }
}
</script>
