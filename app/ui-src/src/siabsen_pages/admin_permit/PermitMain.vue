<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">
        {{ $t('absensi_izin') }}
      </div>
      <div class="text-h6 text-capitalize" v-else>{{ $t('absensi_izin') }}</div>
      <div :class="['row', titleSpacing()]" style="margin-top: 0">
        <div class="col-12 col-md-5"></div>
        <row-dropdown class="q-mt-md" root-class="col-12 col-md-3 q-pr-sm" />
        <search-box :label="$t('siabsen_cari_guru')" class="q-mt-md q-pr-sm" />
      </div>
    </q-card-section>
    <permit-list-wrapper />
    <permit-detail />
    <!-- <staff-list />
    <presence-detail /> -->
  </q-card>
</template>

<script>
import { titleSpacing } from 'src/composables/screen'
import PermitDetail from '../teacher_permit/PermitDetail.vue'
import { onBeforeRouteLeave } from 'vue-router'
import PermitListWrapper from './PermitListWrapper.vue'
import { useSiabsenStore } from 'src/stores/siabsen'

export default {
  components: {
    PermitDetail,
    PermitListWrapper,
  },
  setup() {
    const store = useSiabsenStore()
    store.getPermissionNotif()
    onBeforeRouteLeave(() => {
      store.getPermissionNotif()
    })

    return {
      titleSpacing,
    }
  },
}
</script>
