<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ $t('absensi_izin') }}</div>
      <div class="text-h6 text-capitalize" v-else>{{ $t('absensi_izin') }}</div>
      <div :class="['row', titleSpacing()]" style="margin-top: 0;">
        <div class="col-12 col-md-5"></div>
        <row-dropdown vuex-module="siabsen" class="q-mt-md" root-class="col-12 col-md-3 q-pr-sm" />
        <search-box :label="$t('siabsen_cari_guru')" vuex-module="siabsen" class="q-mt-md q-pr-sm" />
      </div>
    </q-card-section>
    <permit-list class="q-mt-sm" />
    <permit-detail />
    <!-- <staff-list />
    <presence-detail /> -->
  </q-card>
</template>

<script>
import { useStore } from 'vuex'
import { titleSpacing } from 'src/composables/screen'
import PermitList from './PermitList.vue'
import PermitDetail from '../teacher_permit/PermitDetail.vue'
import { onBeforeRouteLeave } from 'vue-router'

export default {
  components: {
    PermitList,
    PermitDetail
},
  setup() {
    const store = useStore()
    store.dispatch('siabsen/getPermissionNotif')
    onBeforeRouteLeave(() => {
      store.dispatch('siabsen/getPermissionNotif')
    })

    return {
        titleSpacing
    }
  },  
}
</script>
