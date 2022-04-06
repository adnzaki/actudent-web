<template>
  <div :class="wrapperPadding()">    
    <q-card class="my-card">
      <q-card-section>
        <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ $t('menu_pegawai') }}</div>
        <div class="text-h6 text-capitalize" v-else>{{ $t('menu_pegawai') }}</div>
        <div :class="['row', titleSpacing()]">
          <main-button class="q-mt-sm" />
          <employee-type class="justify-data-options" />
          <row-dropdown vuex-module="employee" class="q-mt-sm" root-class="col-12 col-md-2" />
          <search-box :label="$t('staff_cari')" vuex-module="employee" class="q-mt-sm" />
        </div>
      </q-card-section>
      <add-employee-form />
      <edit-employee-form />
      <delete-confirm vuex-module="employee" action="deleteEmployee" />
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
import EditEmployeeForm from './EditEmployeeForm.vue'

export default {
  name: 'EmployeeMain',
  components: {
    MainButton, EmployeeType,
    EmployeeTable,
    AddEmployeeForm,
    EditEmployeeForm
  },
  setup() {
    return { wrapperPadding, titleSpacing }
  }
}
</script>
