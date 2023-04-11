<template>
  <div :class="wrapperPadding()">    
    <q-card class="my-card">
      <q-card-section>
        <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ $t('menu_pegawai') }}</div>
        <div class="text-h6 text-capitalize" v-else>{{ $t('menu_pegawai') }}</div>
        <div :class="['row', titleSpacing()]">
          <main-button class="q-mt-sm" />
          <employee-type class="justify-data-options" />
          <row-dropdown class="q-mt-sm" root-class="col-12 col-md-2" />
          <search-box :label="$t('staff_cari')" class="q-mt-sm" />
        </div>
      </q-card-section>
      <add-employee-form />
      <edit-employee-form />
      <delete-confirm :store="store" :action="store.deleteEmployee()" />
      <employee-table />
    </q-card>
  </div>
</template>

<script>
import MainButton from './MainButton.vue'
import EmployeeType from './EmployeeType.vue'
import EmployeeTable from './EmployeeTable.vue'
import AddEmployeeForm from './AddEmployeeForm.vue'
import EditEmployeeForm from './EditEmployeeForm.vue'
import { useEmployeeStore } from 'src/stores/employee'
import { wrapperPadding, titleSpacing } from 'src/composables/screen'

export default {
  components: {
    MainButton, 
    EmployeeType,
    EmployeeTable,
    AddEmployeeForm,
    EditEmployeeForm
  },
  setup() {
    return { 
      titleSpacing, 
      wrapperPadding, 
      store: useEmployeeStore(),
    }
  }
}
</script>
