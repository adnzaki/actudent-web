<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="row">
        <q-btn
          color="teal"
          flat
          rounded
          class="back-button"
          icon="arrow_back"
          @click="$router.push('/teacher-presence/monthly-summary')"
        />
        <div
          class="text-subtitle1 text-uppercase q-mt-xs page-title-pl-5"
          v-if="$q.screen.lt.sm"
        >
          {{ $t('siabsen_rekap_periodik') }}
        </div>
        <div class="text-h6 text-capitalize" v-else>
          {{ $t('siabsen_rekap_periodik') }}
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
    <q-page-sticky
      position="bottom-right mobile-only"
      :offset="fabPos"
      class="force-elevated"
    >
      <q-btn
        fab
        icon="print"
        color="secondary"
        :href="exportPdf()"
        target="_blank"
      />
    </q-page-sticky>
    <print-btn />
  </q-card>
</template>

<script>
import { useQuasar } from 'quasar'
import { useRoute } from 'vue-router'
import PrintBtn from './PrintBtn.vue'
import { fabPos } from 'src/composables/fab'
import TimeRecapMobile from './TimeRecapMobile.vue'
import { useSiabsenStore } from 'src/stores/siabsen'
import { titleSpacing } from 'src/composables/screen'
import PresenceNoteMobile from './PresenceNoteMobile.vue'
import { formatDate, conf } from 'src/composables/common'
import PresenceDetailTable from './PresenceDetailTable.vue'
import PresenceDetailMobile from './PresenceDetailMobile.vue'
import { ref, onMounted, watch, computed, provide } from 'vue'

export default {
  components: {
    PresenceDetailTable,
    PresenceDetailMobile,
    PrintBtn,
    PresenceNoteMobile,
    TimeRecapMobile,
  },
  setup() {
    const store = useSiabsenStore()
    const route = useRoute()
    const $q = useQuasar()

    store.getDetailPresence({
      staffId: route.params.staffId,
      userId: route.params.userId,
      dateStart: route.params.dateStart,
      dateEnd: route.params.dateEnd,
    })

    //const yearMonth = route.params.period.split('-').reverse().join('-')
    //const period = formatDate(`${yearMonth}-01`, 'MMMM YYYY')

    const exportPdf = () => {
      return (
        `${conf.siabsenAPI}print-rekap-individu/` +
        `${route.params.staffId}/` +
        `${route.params.userId}/` +
        `${route.params.dateStart}/` +
        `${route.params.dateEnd}/${$q.cookies.get(conf.cookieName)}`
      )
    }

    provide('print', {
      conf,
      route,
      $q,
    })

    const presenceDetail = computed(() => store.presenceDetail)
    provide('presenceDetail', presenceDetail)

    const treeData = ref([{ label: 'Loading...' }])
    onMounted(() => {
      const detail = computed(() => store.presenceDetail)

      // watch if there is change on presenceDetail state
      // and update treeData...
      watch(detail, () => {
        treeData.value = [
          {
            label: store.presenceDetail.name,
            icon: 'account_circle',
            children: [
              {
                label: store.presenceDetail.nip,
                icon: 'badge',
              },
              // {
              //   label: `${route.params.dateStart}`,
              //   icon: 'calendar_month',
              // }
            ],
          },
        ]
      })
    })

    return {
      fabPos,
      treeData,
      exportPdf,
      titleSpacing,
    }
  },
}
</script>
