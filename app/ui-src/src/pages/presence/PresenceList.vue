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
        <schedule-selector v-if="!store.isTeacherSection" />
      </div>
    </q-card-section>
    <presence-table />
    <journal-form />
    <permission-form />
  </q-card>
</template>

<script>
import { computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { titleSpacing } from 'src/composables/screen'
import { usePresenceStore } from 'src/stores/presence'
import MainButton from './MainButton.vue'
import JournalForm from './JournalForm.vue'
import PresenceTable from './PresenceTable.vue'
import PermissionForm from './PermissionForm.vue'
import ScheduleSelector from './ScheduleSelector.vue'

export default {
  name: 'PresenceList',
  components: {
    MainButton,
    JournalForm,
    PresenceTable,
    PermissionForm,
    ScheduleSelector,
  },
  setup() {
    
    const route = useRoute()
    const router = useRouter()
    const store = usePresenceStore()
    const teacherSection = computed(() => store.isTeacherSection)
    const classId = teacherSection.value ? route.params.classId : route.params.id

    store.classID = classId
    store.presenceList = []

    if(teacherSection.value) {
      store.scheduleID = route.params.scheduleId
      store.helper.activeDate = route.params.activeDate
      store.helper.activeDay = localStorage.getItem('date')

      store.checkJournal()
    }

    const backToClassList = () => {
      const backUrl = teacherSection.value ? '/teacher/presence' : '/presence'

      router.push(backUrl)
      store.scheduleID = ''
      store.showJournalBtn = false
    }

    return { 
      store,
      titleSpacing,
      teacherSection,
      backToClassList,
      className: store.className === '' ? localStorage.getItem('class') : store.className,
      lessonName: store.lessonName === '' ? localStorage.getItem('lesson') : store.lessonName,
    }
  }
}
</script>