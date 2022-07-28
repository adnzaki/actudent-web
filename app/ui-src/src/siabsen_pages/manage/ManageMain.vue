<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ $t('siabsen_manage_page_title') }}</div>
      <div class="text-h6 text-capitalize" v-else>{{ $t('siabsen_manage_page_title') }}</div>
      <div :class="['row', titleSpacing()]">
        <date-selector />
        <row-dropdown v-if="$q.screen.gt.sm" vuex-module="siabsen" class="q-mt-md" root-class="col-12 col-md-3 q-pr-sm" />
        <search-box :label="$t('siabsen_cari_guru')" vuex-module="siabsen" class="q-mt-md q-pr-sm" />
      </div>
    </q-card-section>
    <staff-list />
    <presence-detail />
  </q-card>
</template>

<script>
import { useStore } from 'vuex'
import { titleSpacing } from 'src/composables/screen'
import DateSelector from './DateSelector.vue'
import StaffList from './StaffList.vue';
import PresenceDetail from './PresenceDetail.vue';

export default {
  name: 'ManageMain',
  components: { DateSelector, StaffList, PresenceDetail },
  setup() {
    const store = useStore();
    return {
        titleSpacing
    }
  },  
}
</script>
