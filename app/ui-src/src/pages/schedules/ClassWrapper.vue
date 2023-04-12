<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ $t('menu_jadwal') }}</div>
      <div class="text-h6 text-capitalize" v-else>{{ $t('menu_jadwal') }}</div>
      <div :class="['row', titleSpacing()]">
        <main-button class="q-mt-sm" />
        <row-dropdown class="q-mt-sm" />
        <search-box :label="$t('kelas_cari')" class="q-mt-sm" />
        <mapping-setting-form />
      </div>
    </q-card-section>
    <class-list />
  </q-card>
</template>

<script>
import ClassList from './ClassList.vue'
import MainButton from './MainButton.vue'
import { titleSpacing } from 'src/composables/screen'
import MappingSettingForm from './MappingSettingForm.vue'

export default {
  name: 'ClassWrapper',
  components: {
    ClassList,
    MainButton,
    MappingSettingForm
  },
  setup() {
    return {
      titleSpacing
    }
  }
}
</script>