<template>
  <div :class="wrapperPadding()">    
    <q-card class="my-card">
      <q-card-section>
        <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ lang.menu_pegawai }}</div>
        <div class="text-h6 text-capitalize" v-else>{{ lang.menu_pegawai }}</div>
        <div :class="['row', titleSpacing()]">
          <main-button class="q-mt-sm" />
          <employee-type class="justify-data-options" />
          <row-dropdown vuex-module="employee" class="q-mt-sm" root-class="col-12 col-md-2" />
          <search-box :label="lang.staff_cari" vuex-module="employee" class="q-mt-sm" />
        </div>
      </q-card-section>
      <add-employee-form />
      <!-- <edit-student-form />
      <delete-confirm vuex-module="employee" action="deleteStudent" /> -->
      <employee-table />
    </q-card>
  </div>
</template>

<script>
import { computed } from 'vue'
import { wrapperPadding, titleSpacing } from 'src/composables/screen'
import MainButton from './MainButton.vue'
import EmployeeType from './EmployeeType.vue'
import EmployeeTable from './EmployeeTable.vue'
import AddEmployeeForm from './AddEmployeeForm.vue'

export default {
  name: 'EmployeeMain',
  components: {
    MainButton, EmployeeType,
    EmployeeTable,
    AddEmployeeForm
  },
  provide() {
    return {
      textLang: computed(() => this.lang)
    }
  },
  mounted() {
    setTimeout(() => {
      this.fetchLang('Admin')
      this.fetchLang('AdminPegawai')
      this.fetchLang('AdminUser')
    }, 1000);
  },
  setup() {
    return { wrapperPadding, titleSpacing }
  }
}
</script>
