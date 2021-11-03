<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">
        {{ $t('jadwal_daftar_mapel') }} {{ $store.state.schedule.className }}
      </div>
      <div class="text-h6 text-capitalize" v-else>
        {{ $t('jadwal_daftar_mapel') }} {{ $store.state.schedule.className }}
      </div>
      <div :class="['row', titleSpacing()]">
        <lessons-button class="q-mt-sm" />
      </div>
    </q-card-section>
    <lessons-list />
    <lesson-add-form />
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

export default {
  name: 'LessonsWrapper',
  components: {
    LessonsButton,
    LessonsList,
    LessonAddForm
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