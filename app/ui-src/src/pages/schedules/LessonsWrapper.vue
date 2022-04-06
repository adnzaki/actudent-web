<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="row">
        <q-btn color="teal" flat rounded
          class="back-button"
          icon="arrow_back" 
          @click="$router.push('/schedules')" />
        <div class="text-subtitle1 text-uppercase q-mt-xs page-title-pl-5" v-if="$q.screen.lt.sm">
          {{ $t('jadwal_daftar_mapel') }}
        </div>
        <div class="text-h6 text-capitalize" v-else>
          {{ $t('jadwal_daftar_mapel') }} {{ $store.state.schedule.className }}
        </div>
      </div>
      <div :class="['row', titleSpacing()]">
        <lessons-button class="q-mt-sm" />
      </div>
    </q-card-section>
    <lessons-list />
    <lesson-add-form />
    <lesson-edit-form />
    <delete-confirm vuex-module="schedule" action="deleteLesson" />
  </q-card>
</template>

<script>
import { onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { useStore } from 'vuex'
import { titleSpacing } from 'src/composables/screen'
import LessonsButton from './LessonsButton.vue'
import LessonsList from './LessonsList.vue'
import LessonAddForm from './LessonAddForm.vue'
import LessonEditForm from './LessonEditForm.vue'

export default {
  name: 'LessonsWrapper',
  components: {
    LessonsButton,
    LessonsList,
    LessonAddForm,
    LessonEditForm
  },
  setup() {
    const route = useRoute()
    const store = useStore()

    onMounted(() => {
      store.commit('schedule/getLessonOptions', route.params.id)
      store.commit('grade/getTeacher')
    })

    return {
      titleSpacing
    }
  }
}
</script>