<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">
        {{ `${$t('absensi_title')} - ${$store.state.grade.classMember.name}` }}
      </div>
      <div class="text-h6 text-capitalize" v-else>
        {{ `${$t('absensi_title')} - ${$store.state.grade.classMember.name}` }}
      </div>
      <div :class="['row', titleSpacing()]">
        <main-button class="q-mt-sm" />
        <schedule-selector />        
      </div>
    </q-card-section>
    <presence-table />
    <journal-form />
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

export default {
  name: 'PresenceList',
  components: {
    MainButton,
    ScheduleSelector,
    PresenceTable,
    JournalForm
  },
  setup() {
    
    const route = useRoute()
    const store = useStore()

    store.commit('grade/getDetail', route.params.id)
    store.state.presence.classID = route.params.id
    store.state.presence.presenceList = []

    return {
      titleSpacing
    }
  }
}
</script>