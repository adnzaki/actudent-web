<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="row">
        <q-btn color="teal" flat rounded
          class="back-button"
          icon="arrow_back" 
          @click="$router.push('/teacher-presence/monthly-summary')" />
        <div class="text-subtitle1 text-uppercase q-mt-xs page-title-pl-5" v-if="$q.screen.lt.sm">
          {{ $t('siabsen_detail_absensi') }}
        </div>
        <div class="text-h6 text-capitalize" v-else>
          {{ $t('siabsen_detail_absensi') }}
        </div>
      </div>
      <div :class="['row', titleSpacing()]">
        <q-tree :nodes="treeData" node-key="label" />
      </div>
    </q-card-section>
    <div class="row mobile-hide">
      <div class="col-6">
        <presence-note-mobile bg-color="bg-blue" />
      </div>
      <div class="col-6">
        <time-recap-mobile bg-color="bg-deep-orange" />
      </div>
    </div>
    <presence-detail-table class="q-mt-md q-mb-xl" />
    <presence-detail-mobile class="q-mt-md" />
    <q-page-sticky position="bottom-right mobile-only" 
      :offset="fabPos" 
      class="force-elevated">
      <q-btn fab icon="print" color="secondary" 
        :href="exportPdf()" target="_blank" />    
    </q-page-sticky>
    <print-btn />
  </q-card>
</template>

<script>
import { ref, onMounted, watch, computed, provide } from 'vue'
import { useStore } from 'vuex'
import { useRoute } from 'vue-router'
import { titleSpacing } from 'src/composables/screen'
import PresenceDetailTable from './PresenceDetailTable.vue'
import { formatDate, conf } from 'src/composables/common'
import { fabPos } from 'src/composables/fab'
import { useQuasar } from 'quasar'
import PresenceDetailMobile from './PresenceDetailMobile.vue'
import PrintBtn from './PrintBtn.vue'
import PresenceNoteMobile from './PresenceNoteMobile.vue'
import TimeRecapMobile from './TimeRecapMobile.vue'

export default {
  components: {
    PresenceDetailTable,
    PresenceDetailMobile,
    PrintBtn,
    PresenceNoteMobile,
    TimeRecapMobile
},
  setup() {
    const store = useStore()
    const route = useRoute()
    const $q = useQuasar()

    store.commit('siabsen/getDetailPresence', {
      staffId: route.params.staffId, 
      userId: route.params.userId,
      period: route.params.period
    })      

    const yearMonth = route.params.period.split('-').reverse().join('-')
    const period = formatDate(`${yearMonth}-01`, 'MMMM YYYY')

    const exportPdf = () => {
      return `${conf.siabsenAPI}print-rekap-individu/` +
             `${route.params.staffId}/` + 
             `${route.params.userId}/` + 
             `${route.params.period}/${$q.cookies.get(conf.cookieName)}`
    }

    provide('print', {
      conf, route, $q
    })

    const presenceDetail = computed(() => store.state.siabsen.presenceDetail)
    provide('presenceDetail', presenceDetail)

    const treeData = ref([{ label: 'Loading...' }])
    onMounted(() => {
      const detail = computed(() => store.state.siabsen.presenceDetail)

      // watch if there is change on presenceDetail state
      // and update treeData...
      watch(detail, () => {
        treeData.value = [
          {
            label: store.state.siabsen.presenceDetail.name,
            icon: 'account_circle',
            children: [
              {
                label: store.state.siabsen.presenceDetail.nip,
                icon: 'badge',
              },
              {
                label: period,
                icon: 'calendar_month',
              }
            ]
          }
        ]        
      })
    })

    return {
      fabPos,
      treeData,
      exportPdf,
      titleSpacing
    }
  },  
}
</script>
