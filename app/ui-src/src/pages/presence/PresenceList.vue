<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">
        {{ `${$t('absensi_title')} - ${$store.state.presence.className}` }}
      </div>
      <div class="text-h6 text-capitalize" v-else>
        {{ `${$t('absensi_title')} - ${$store.state.presence.className}` }}
      </div>
      <div :class="['row', titleSpacing()]">
        <main-button class="q-mt-sm" />
        <schedule-selector />        
      </div>
    </q-card-section>
    <presence-table />
    <journal-form />
    <permission-form />
  </q-card>
</template>

<script>
import { useRoute } from 'vue-router'
import { useStore } from 'vuex'
import { titleSpacing } from 'src/composables/screen'
import MainButton from './MainButton.vue'
import ScheduleSelector from './ScheduleSelector.vue'
import PresenceTable from './PresenceTable.vue'
import JournalForm from './JournalForm.vue'
import PermissionForm from './PermissionForm.vue'

export default {
  name: 'PresenceList',
  components: {
    MainButton,
    ScheduleSelector,
    PresenceTable,
    JournalForm,
    PermissionForm
  },
  setup() {
    
    const route = useRoute()
    const store = useStore()

    store.commit('presence/getClassName', route.params.id)
    store.state.presence.classID = route.params.id
    store.state.presence.presenceList = []

    return {
      titleSpacing
    }
  }
}
</script>