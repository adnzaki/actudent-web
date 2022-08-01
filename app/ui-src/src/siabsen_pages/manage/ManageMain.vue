<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ $t('siabsen_presence_monitor') }}</div>
      <div class="text-h6 text-capitalize" v-else>{{ $t('siabsen_presence_monitor') }}</div>
      <div :class="['row', titleSpacing()]">
        <date-selector />
        <presence-selector class="q-mt-md" />
        <row-dropdown v-if="$q.screen.gt.sm" vuex-module="siabsen" class="q-mt-md" root-class="col-12 col-md-2 q-pr-sm" />
        <search-box :label="$t('siabsen_cari_guru')" vuex-module="siabsen" root-class="col-12 col-md-3" class="q-mt-md q-pr-sm" />
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
import PresenceSelector from './PresenceSelector.vue';

export default {
  name: 'ManageMain',
  components: { DateSelector, StaffList, PresenceDetail, PresenceSelector },
  setup() {
    const store = useStore();
    return {
        titleSpacing
    }
  },  
}
</script>
