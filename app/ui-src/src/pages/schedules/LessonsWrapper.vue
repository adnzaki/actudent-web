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
  </q-card>
</template>

<script>
import { titleSpacing } from 'src/composables/screen'
import LessonsButton from './LessonsButton.vue'
import LessonsList from './LessonsList.vue'

export default {
  name: 'LessonsWrapper',
  components: {
    LessonsButton,
    LessonsList
  },
  setup() {
    return {
      titleSpacing
    }
  }
}
</script>