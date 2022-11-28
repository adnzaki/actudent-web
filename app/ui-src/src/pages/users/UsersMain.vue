<template>
  <div :class="wrapperPadding()">    
    <q-card class="my-card">
      <q-card-section>
        <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ $t('user_title') }}</div>
        <div class="text-h6 text-capitalize" v-else>{{ $t('user_title') }}</div>
        <div :class="['row', titleSpacing()]">
          <!-- <main-button class="q-mt-sm" /> -->
          <user-type class="justify-data-options" />
          <row-dropdown vuex-module="users" class="q-mt-sm" root-class="col-12 col-md-2" />
          <search-box :label="$t('user_cari')" vuex-module="users" class="q-mt-sm" />
        </div>
      </q-card-section>
      <user-table />
      <!-- <add-employee-form />
      <edit-employee-form />
      <delete-confirm vuex-module="employee" action="deleteEmployee" />
      <employee-table /> -->
    </q-card>
  </div>
</template>

<script>
import { computed } from 'vue'
import { wrapperPadding, titleSpacing } from 'src/composables/screen'
import UserType from './UserType.vue'
import UserTable from './UserTable.vue'

export default {
  components: {
    UserType,
    UserTable
  },
  setup() {
    return { wrapperPadding, titleSpacing }
  }
}
</script>
