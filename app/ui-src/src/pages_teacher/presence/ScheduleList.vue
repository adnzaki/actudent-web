<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ $t('guru_absensi_page_title') }}</div>
      <div class="text-h6 text-capitalize" v-else>{{ $t('guru_absensi_page_title') }}</div>
      <div :class="['row', titleSpacing()]">
        <date-selector />
      </div>
    </q-card-section>
    <schedule-items class="q-mt-sm" />
  </q-card>
</template>

<script>
import { useStore } from 'vuex'
import { titleSpacing } from 'src/composables/screen'
import DateSelector from './DateSelector.vue'
import ScheduleItems from './ScheduleItems.vue'

export default {
  name: 'ScheduleList',
  components: { DateSelector, ScheduleItems },
  setup () {   
    const store = useStore()
    
    return { 
      titleSpacing 
    }
  }
}
</script>
