<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ $t('menu_jadwal') }}</div>
      <div class="text-h6 text-capitalize" v-else>{{ $t('menu_jadwal') }}</div>
      <div :class="['row', titleSpacing()]">
        <main-button class="q-mt-sm" />
        <row-dropdown vuex-module="schedule" class="q-mt-sm" />
        <search-box :label="$t('kelas_cari')" vuex-module="schedule" class="q-mt-sm" />
      </div>
    </q-card-section>
    <class-list />
  </q-card>
</template>

<script>
import { titleSpacing } from 'src/composables/screen'
import ClassList from './ClassList.vue'
import MainButton from './MainButton.vue'

export default {
  name: 'ClassWrapper',
  components: {
    ClassList,
    MainButton
  },
  setup() {
    return {
      titleSpacing
    }
  }
}
</script>