<template>
  <div class="col-12 col-md-4">
    <div class="q-gutter-xs mobile-hide">
      <q-btn color="deep-purple" icon="settings" class="q-pl-sm" :label="$t('menu_pengaturan')"
        @click="store.showSettingsForm = true" />
    </div>

    <q-page-sticky position="bottom-right" 
      :offset="fabPos" 
      class="mobile-only force-elevated"
      v-if="!store.showSettingsForm">
      <q-btn fab icon="settings" color="deep-purple" 
        @click="store.showSettingsForm = true" 
      />
    </q-page-sticky>
  </div>
</template>

<script>
import { fabPos } from 'src/composables/fab'
import { useScheduleStore } from 'src/stores/schedule'

export default {
  name: 'MainButton',
  setup() {
    const store = useScheduleStore()
    
    return { 
      store,
      fabPos
    }
  }
}
</script>