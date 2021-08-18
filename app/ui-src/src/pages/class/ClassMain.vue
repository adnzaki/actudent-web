<template>
  <div :class="wrapperPadding()">    
    <q-card class="my-card">
      <q-card-section>
        <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ lang.menu_kelas }}</div>
        <div class="text-h6 text-capitalize" v-else>{{ lang.menu_kelas }}</div>
        <div :class="['row', titleSpacing()]">
          <main-button class="q-mt-sm" />
          <row-dropdown vuex-module="grade" class="q-mt-sm" />
          <search-box :label="lang.kelas_cari" vuex-module="grade" class="q-mt-sm" />
        </div>
      </q-card-section>
      <add-class-form />
      <edit-class-form />
      <delete-confirm vuex-module="grade" action="deleteClass" />
      <class-table />
    </q-card>
  </div>
</template>

<script>
import { computed } from 'vue'
import { wrapperPadding, titleSpacing } from 'src/composables/screen'
import MainButton from './MainButton.vue'
import ClassTable from './ClassTable.vue'
import AddClassForm from './AddClassForm.vue'
import EditClassForm from './EditClassForm.vue'

export default {
  name: 'ClassMain',
  components: {
    MainButton,
    ClassTable,
    AddClassForm,
    EditClassForm
  },
  provide() {
    return {
      textLang: computed(() => this.lang)
    }
  },
  mounted () {
    setTimeout(() => {
      this.fetchLang('Admin')
      this.fetchLang('AdminKelas')   
    }, 1000)
  },
  setup () {
    return { wrapperPadding, titleSpacing }
  }
}
</script>
