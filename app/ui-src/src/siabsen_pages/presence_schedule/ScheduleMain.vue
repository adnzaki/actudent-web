<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ $t('siabsen_atur_jadwal') }}</div>
      <div class="text-h6 text-capitalize" v-else>{{ $t('siabsen_atur_jadwal') }}</div>
      <div :class="['row', titleSpacing()]">
        <!-- <div class="offset-md-5"></div> -->
        <row-dropdown vuex-module="siabsen" class="q-mt-md" root-class="col-12 offset-md-6 col-md-2 q-pr-sm" />
        <search-box :label="$t('siabsen_cari_guru')" vuex-module="siabsen" class="q-mt-md q-pr-sm" />
      </div>
    </q-card-section>
    <employee-list />
    <employee-list-mobile />
  </q-card>
</template>

<script>
import { useStore } from 'vuex'
import { titleSpacing } from 'src/composables/screen'
import EmployeeList from './EmployeeList.vue';
import EmployeeListMobile from './EmployeeListMobile.vue';

export default {
  name: 'ManageMain',
  components: { EmployeeList, EmployeeListMobile },
  setup() {
    const store = useStore();
    return {
        titleSpacing
    }
  },  
}
</script>
