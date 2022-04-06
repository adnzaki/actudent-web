<template>
  <div :class="wrapperPadding()">    
    <q-card class="my-card">
      <q-card-section>
        <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ $t('menu_siswa') }}</div>
        <div class="text-h6 text-capitalize" v-else>{{ $t('menu_siswa') }}</div>
        <div :class="['row', titleSpacing()]">
          <main-button class="q-mt-sm" />
          <dropdown-search 
            class="justify-data-options" 
            flex-grid="col-md-3"
            vuex-module="student"
            selected="getStudentsByClass"
            loader="getClassGroup"
            :label="$t('siswa_semua_kelas')"
            :list="$store.state.student.classGroupList"
            :options-value="{ label: 'grade_name', value: 'grade_id' }"
          />
          <row-dropdown vuex-module="student" class="q-mt-sm" root-class="col-12 col-md-2" />
          <search-box :label="$t('siswa_cari')" vuex-module="student" class="q-mt-sm" />
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
import { onMounted } from 'vue'
import { useStore } from 'vuex'
import MainButton from './MainButton.vue'
import StudentTable from './StudentTable.vue'
import AddStudentForm from './AddStudentForm.vue'
import EditStudentForm from './EditStudentForm.vue'
import { wrapperPadding, titleSpacing } from 'src/composables/screen'

export default {
  name: 'StudentMain',
  components: { 
    MainButton,
    StudentTable,
    AddStudentForm,
    EditStudentForm,
  },
  setup() {
    const store = useStore()
    onMounted(() => {
      store.commit('student/getStudentLimit')
    })
    return { wrapperPadding, titleSpacing }
  }
}
</script>
