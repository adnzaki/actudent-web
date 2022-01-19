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
  </q-card>
</template>

<script>
import { useRoute } from 'vue-router'
import { useStore } from 'vuex'
import { useI18n } from 'vue-i18n'
import { titleSpacing } from 'src/composables/screen'
import MainButton from './MainButton.vue'
import ScheduleSelector from './ScheduleSelector.vue'
import PresenceTable from './PresenceTable.vue'

export default {
  name: 'PresenceList',
  components: {
    MainButton,
    ScheduleSelector,
    PresenceTable
  },
  setup() {
    
    const route = useRoute()
    const store = useStore()
    const { t } = useI18n()

    store.commit('grade/getDetail', route.params.id)
    store.state.presence.classID = route.params.id

    return {
      titleSpacing
    }
  }
}
</script>