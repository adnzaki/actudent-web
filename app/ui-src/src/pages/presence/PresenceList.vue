<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="row" v-if="teacherSection">
        <q-btn color="teal" flat rounded
          class="back-button"
          icon="arrow_back" 
          @click="backToClassList()" />
        <div class="text-subtitle1 text-uppercase q-mt-xs page-title-pl-5" v-if="$q.screen.lt.sm">
          {{ `${lessonName} - ${className}` }}
        </div>
        <div class="text-h6 text-capitalize" v-else>
          {{ `${lessonName} - ${className}` }}
        </div>
      </div>
      <div class="row" v-else>
        <q-btn color="teal" flat rounded
          class="back-button"
          icon="arrow_back" 
          @click="backToClassList()" />
        <div class="text-subtitle1 text-uppercase q-mt-xs page-title-pl-5" v-if="$q.screen.lt.sm">
          {{ $t('absensi_title') }}
        </div>
        <div class="text-h6 text-capitalize" v-else>
          {{ `${$t('absensi_title')} - ${className}` }}
        </div>
      </div>
      <div :class="['row', titleSpacing()]">
        <main-button class="q-mt-sm" />
        <schedule-selector v-if="!$store.state.presence.isTeacherSection" />        
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
import { computed } from 'vue'
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
    const teacherSection = computed(() => store.state.presence.isTeacherSection)
    const classId = teacherSection.value ? route.params.classId : route.params.id

    store.state.presence.classID = classId
    store.state.presence.presenceList = []

    if(teacherSection.value) {
      store.state.presence.scheduleID = route.params.scheduleId
      store.state.presence.helper.activeDate = route.params.activeDate
      store.dispatch('presence/checkJournal')
    }

    const backToClassList = () => {
      const backUrl = teacherSection.value ? '/teacher/presence' : '/presence'
      router.push(backUrl)
      store.state.presence.scheduleID = ''
      store.state.presence.showJournalBtn = false
    }

    return {
      className: store.state.presence.className === '' 
                ? localStorage.getItem('class')
                : store.state.presence.className,
      lessonName: store.state.presence.lessonName === '' 
                ? localStorage.getItem('lesson')
                : store.state.presence.lessonName,
      teacherSection,
      titleSpacing,
      backToClassList
    }
  }
}
</script>