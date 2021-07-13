<template>
  <div :class="wrapperPadding()">    
    <q-card class="my-card">
      <q-card-section>
        <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ lang.menu_pegawai }}</div>
        <div class="text-h6 text-capitalize" v-else>{{ lang.menu_pegawai }}</div>
        <div :class="['row', titleSpacing()]">
          <!-- <main-button class="q-mt-sm" />
          <class-options class="justify-data-options" />
          <row-dropdown vuex-module="student" class="q-mt-sm" root-class="col-12 col-md-2" />
          <search-box :label="lang.siswa_cari" vuex-module="student" class="q-mt-sm" /> -->
        </div>
      </q-card-section>
      <!-- <add-student-form />
      <edit-student-form />
      <delete-confirm vuex-module="employee" action="deleteStudent" />
      <student-table /> -->
    </q-card>
  </div>
</template>

<script>
import { computed, onMounted } from 'vue'
import { useStore } from 'vuex'
import { wrapperPadding, titleSpacing } from 'src/composables/screen'

export default {
  name: 'EmployeeMain',
  components: {},
  provide() {
    return {
      textLang: computed(() => this.lang)
    }
  },
  mounted() {
    setTimeout(() => {
      this.fetchLang('Admin')
      this.fetchLang('AdminPegawai')
    }, 1000);
  },
  setup() {
    const store = useStore()
    onMounted(() => {})
    return { wrapperPadding, titleSpacing }
  }
}
</script>
