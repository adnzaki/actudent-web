<template>
    <q-card class="my-card">
      <q-card-section>
        <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">
          {{ $t('absensi_leave_request') }}
        </div>
        <div class="text-h6 text-capitalize" v-else>{{ $t('absensi_leave_request') }}</div>
        <div :class="['row', titleSpacing()]">
          <main-button class="q-mt-sm" />
          <!-- <date-selector />
          <row-dropdown vuex-module="siabsen" class="q-mt-md" root-class="col-12 col-md-3 q-pr-sm" />
          <search-box :label="$t('siabsen_cari_guru')" vuex-module="siabsen" class="q-mt-md q-pr-sm" /> -->
        </div>
      </q-card-section>
      <!-- <permit-request-form /> -->
      <leave-request-list class="q-mt-lg" />
      <!-- <permit-detail /> -->
      <delete-confirm :store="store" @action="store.deletePermission()" />
      <!-- <staff-list />
      <presence-detail /> -->
    </q-card>
  </template>
  
  <script>
  import { titleSpacing } from 'src/composables/screen'
  import MainButton from './MainButton.vue'
//   import PermitRequestForm from './PermitRequestForm.vue'
  import LeaveRequestList from './LeaveRequestList.vue'
//   import PermitDetail from './PermitDetail.vue'
  import { useSiabsenStore } from 'src/stores/siabsen'
  
  export default {
    components: {
      MainButton,
      LeaveRequestList,
    //   PermitRequestForm,
    //   PermitList,
    //   PermitDetail,
    },
    setup() {
      const store = useSiabsenStore()
  
      return {
        store,
        titleSpacing,
      }
    },
  }
  </script>
  