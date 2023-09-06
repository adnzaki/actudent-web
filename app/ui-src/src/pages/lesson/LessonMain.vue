<template>
  <div :class="wrapperPadding()">
    <q-card class="my-card">
      <q-card-section class="q-mb-md">
        <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">
          {{ $t('menu_mapel') }}
        </div>
        <div class="text-h6 text-capitalize" v-else>{{ $t('menu_mapel') }}</div>
        <div :class="['row', titleSpacing()]">
          <main-button class="q-mt-sm" />
          <row-dropdown class="q-mt-sm" />
          <search-box :label="$t('mapel_cari')" class="q-mt-sm" />
        </div>
      </q-card-section>
      <add-lesson-form />
      <edit-lesson-form />
      <delete-confirm :store="store" @action="store.deleteLesson()" />
      <lesson-table />
    </q-card>
  </div>
</template>

<script>
import MainButton from './MainButton.vue'
import LessonTable from './LessonTable.vue'
import AddLessonForm from './AddLessonForm.vue'
import EditLessonForm from './EditLessonForm.vue'
import { useLessonStore } from 'src/stores/lesson'
import { wrapperPadding, titleSpacing } from 'src/composables/screen'

export default {
  name: 'LessonMain',
  components: {
    MainButton,
    LessonTable,
    AddLessonForm,
    EditLessonForm,
  },
  setup() {
    const store = useLessonStore()

    return {
      store,
      wrapperPadding,
      titleSpacing,
    }
  },
}
</script>
