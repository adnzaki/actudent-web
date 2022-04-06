<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="row">
        <q-btn color="teal" flat rounded
          class="back-button"
          icon="arrow_back" 
          @click="backToClassList()" />
        <div class="text-subtitle1 text-uppercase q-mt-xs page-title-pl-5" v-if="$q.screen.lt.sm">
          {{ $t('absensi_title') }}
        </div>
        <div class="text-h6 text-capitalize" v-else>
          {{ `${$t('absensi_title')} - ${$store.state.presence.className}` }}
        </div>
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
import { useRouter, useRoute } from 'vue-router'
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
    const router = useRouter()

    store.commit('presence/getClassName', route.params.id)
    store.state.presence.classID = route.params.id
    store.state.presence.presenceList = []

    const backToClassList = () => {
      router.push('/presence')
      store.state.presence.scheduleID = ''
      store.state.presence.showJournalBtn = false
    }

    return {
      titleSpacing,
      backToClassList
    }
  }
}
</script>