<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="row">
        <q-btn
          color="teal"
          flat
          rounded
          class="back-button"
          icon="arrow_back"
          @click="$router.push('/schedules')"
        />
        <div
          class="text-subtitle1 text-uppercase q-mt-xs page-title-pl-5"
          v-if="$q.screen.lt.sm"
        >
          {{ $t('jadwal_daftar_mapel') }}
        </div>
        <div class="text-h6 text-capitalize" v-else>
          {{ $t('jadwal_daftar_mapel') }} {{ store.className }}
        </div>
      </div>
      <div :class="['row', titleSpacing()]">
        <lessons-button class="q-mt-sm" />
      </div>
    </q-card-section>
    <lessons-list />
    <lesson-add-form />
    <lesson-edit-form />
    <delete-confirm :store="store" @action="store.deleteLesson()" />
  </q-card>
</template>

<script>
import { onMounted } from 'vue'
import { useRoute } from 'vue-router'
import LessonsList from './LessonsList.vue'
import LessonsButton from './LessonsButton.vue'
import LessonAddForm from './LessonAddForm.vue'
import LessonEditForm from './LessonEditForm.vue'
import { titleSpacing } from 'src/composables/screen'
import { useScheduleStore } from 'src/stores/schedule'
import { useClassStore } from 'src/stores/class'

export default {
  name: 'LessonsWrapper',
  components: {
    LessonsButton,
    LessonsList,
    LessonAddForm,
    LessonEditForm,
  },
  setup() {
    const route = useRoute()
    const store = useScheduleStore()
    const classStore = useClassStore()

    onMounted(() => {
      store.getLessonOptions(route.params.id)
      classStore.getTeacher()
    })

    return {
      store,
      titleSpacing,
    }
  },
}
</script>
