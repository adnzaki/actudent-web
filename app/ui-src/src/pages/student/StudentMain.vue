<template>
  <div :class="wrapperPadding()">
    <q-card class="my-card">
      <q-card-section class="q-mb-md">
        <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">
          {{ $t('menu_siswa') }}
        </div>
        <div class="text-h6 text-capitalize" v-else>{{ $t('menu_siswa') }}</div>
        <div :class="['row', titleSpacing()]">
          <main-button class="q-mt-sm" />
          <dropdown-search
            class="justify-data-options"
            flex-grid="col-md-3"
            @selected="store.getStudentsByClass"
            label="Filter"
            :list="store.classGroupList"
            load-on-route
            :options-value="{ label: 'grade_name', value: 'grade_id' }"
          />
          <row-dropdown class="q-mt-sm" root-class="col-12 col-md-2" />
          <search-box :label="$t('siswa_cari')" class="q-mt-sm" />
        </div>
      </q-card-section>
      <add-student-form />
      <edit-student-form />
      <delete-confirm :store="store" @action="store.deleteStudent()" />
      <student-table />
    </q-card>
  </div>
</template>

<script>
import { onMounted } from 'vue'
import MainButton from './MainButton.vue'
import StudentTable from './StudentTable.vue'
import AddStudentForm from './AddStudentForm.vue'
import EditStudentForm from './EditStudentForm.vue'
import { useStudentStore } from 'src/stores/student'
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
    const store = useStudentStore()

    onMounted(() => {
      store.getStudents()
      store.getClassGroup()
      store.getStudentLimit()
    })

    return {
      store,
      titleSpacing,
      wrapperPadding,
    }
  },
}
</script>
