<template>
  <div class="q-pa-md">    
    <q-card class="my-card">
      <q-card-section>
        <div class="text-h6 text-capitalize">{{ lang.siswa_title }}</div>
        <div class="row q-mt-md">
          <main-button class="q-mt-sm" />
          <class-options />
          <row-dropdown vuex-module="student" class="q-mt-sm" root-class="col-12 col-md-2 q-ml-xs" />
          <search-box :label="lang.siswa_cari" vuex-module="student" class="q-mt-sm" />
        </div>
      </q-card-section>
      <!-- <add-parent-form :lang="lang" /> -->
      <!-- <edit-parent-form :lang="lang" /> -->
      <!-- <delete-confirm :lang="lang" /> -->
      <student-table />
    </q-card>
  </div>
</template>

<script>
import { computed } from 'vue'
import MainButton from './MainButton.vue'
import ClassOptions from './ClassOptions.vue'
import StudentTable from './StudentTable.vue'

export default {
  name: 'StudentMain',
  components: { 
    MainButton, ClassOptions,
    StudentTable,    
  },
  provide() {
    return {
      textLang: computed(() => this.lang)
    }
  },
  mounted() {
    setTimeout(() => {
      this.fetchLang('Admin')
      this.fetchLang('AdminSiswa')
    }, 1000);
  }
}
</script>
