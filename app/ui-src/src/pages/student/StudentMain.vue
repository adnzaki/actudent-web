<template>
  <div class="q-pa-md">    
    <q-card class="my-card">
      <q-card-section>
        <div class="text-h6 text-capitalize">{{ lang.siswa_title }}</div>
        <div class="row q-mt-md">
          <main-button class="q-mt-sm" />
          <class-options :style="justifyDataOptions()" />
          <row-dropdown vuex-module="student" class="q-mt-sm" root-class="col-12 col-md-2" />
          <search-box :label="lang.siswa_cari" vuex-module="student" class="q-mt-sm" />
        </div>
      </q-card-section>
      <add-student-form />
      <edit-student-form />
      <delete-confirm vuex-module="student" action="deleteStudent" />
      <student-table />
    </q-card>
  </div>
</template>

<script>
import { computed } from 'vue'
import MainButton from './MainButton.vue'
import ClassOptions from './ClassOptions.vue'
import StudentTable from './StudentTable.vue'
import AddStudentForm from './AddStudentForm.vue'
import EditStudentForm from './EditStudentForm.vue'
import { justifyDataOptions } from '../../composables/screen'

export default {
  name: 'StudentMain',
  components: { 
    MainButton, ClassOptions,
    StudentTable,
    AddStudentForm,
    EditStudentForm,
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
  },
  setup() {
    return { justifyDataOptions }
  }
}
</script>
