<template>
  <div :class="wrapperPadding()">  
    <q-card class="my-card">
      <q-card-section>
        <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ $t('menu_mapel') }}</div>
        <div class="text-h6 text-capitalize" v-else>{{ $t('menu_mapel') }}</div>
        <div :class="['row', titleSpacing()]">
          <main-button class="q-mt-sm" />
          <row-dropdown vuex-module="lesson" class="q-mt-sm" />
          <search-box :label="$t('mapel_cari')" vuex-module="lesson" class="q-mt-sm" />
        </div>
      </q-card-section>
      <add-lesson-form />
      <edit-lesson-form />
      <delete-confirm vuex-module="lesson" action="deleteLesson" />
      <lesson-table />
    </q-card>
  </div>
</template>

<script>
import { wrapperPadding, titleSpacing } from 'src/composables/screen'
import MainButton from './MainButton.vue'
import LessonTable from './LessonTable.vue'
import AddLessonForm from './AddLessonForm.vue'
import EditLessonForm from './EditLessonForm.vue'

export default {
  name: 'LessonMain',
  components: { 
    MainButton,
    LessonTable,
    AddLessonForm,
    EditLessonForm,
  },
  setup() {
    return {
      wrapperPadding, titleSpacing
    }
  }
}
</script>
