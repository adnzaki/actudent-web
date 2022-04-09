<template>
  <div class="col-12 col-sm-3 col-md-3 q-mt-sm q-px-xs">
    <q-select
      outlined
      v-model="period.semester"
      :options="periodOptions"
      dense
      @update:model-value="periodSelected"
    />
  </div>

  <div class="col-12 col-sm-3 col-md-3 q-mt-sm q-px-xs">
    <q-select
      outlined
      v-model="period.year"
      :options="yearOptions"
      dense
      @update:model-value="yearSelected"
    />
  </div>

  <div class="col-12 col-sm-3 col-md-2 q-mt-sm q-px-xs">
    <q-btn color="deep-purple" 
      style="width: 100%;" 
      icon="preview" 
      :label="$t('tampilkan')"
      @click="$store.dispatch('presence/getPeriodSummary')" />
  </div>

  <q-page-sticky position="bottom-right" :offset="fabPos" class="force-elevated">
    <q-btn fab icon="print" color="secondary" 
      :disable="draggingFab"
      v-touch-pan.prevent.mouse="moveFab"
      :href="exportPdf()" target="_blank" />    
  </q-page-sticky>
</template>
<script>
import { ref } from 'vue'
import { useI18n } from 'vue-i18n'
import { useStore } from 'vuex'
import { useRoute } from 'vue-router'
import { useQuasar } from 'quasar'
import { fabPos, draggingFab, moveFab } from 'src/composables/fab'
import { conf } from 'src/composables/common'

export default {
  name: 'PeriodSelector',
  setup() {
    const { t } = useI18n()
    const store = useStore()
    const periodOptions = ref([])
    const period = ref({})
    const route = useRoute()
    const $q = useQuasar()

    const periodSelected = model => {
      store.state.presence.selectedPeriod.semester = model.value
    }

    const yearSelected = model => {
      store.state.presence.selectedPeriod.year = model.value
    } 

    // current active year
    store.state.presence.selectedPeriod.semester = '2'
    store.state.presence.selectedPeriod.year = 2021

    setTimeout(() => {
      period.value = {
        semester: { label: t('genap'), value: store.state.presence.selectedPeriod.semester },
        year: { label: '2021/2022', value: store.state.presence.selectedPeriod.year }
      }

      periodOptions.value = [
        { label: t('ganjil'), value: '1' },
        { label: t('genap'), value: '2' },
      ]
    }, 1500)  

    const token = $q.cookies.get(conf.cookieName)

    const exportPdf = () => {
      return `${conf.adminAPI}absensi/ekspor-rekap-semester/` +
              `${route.params.id}/` +
              `${store.state.presence.selectedPeriod.semester}/` +
              `${store.state.presence.selectedPeriod.year}/${token}`

    }

    return {
      periodOptions,
      yearOptions: [
        { label: t('2020/2021'), value: 2020 },
        { label: t('2021/2022'), value: 2021 },
      ],
      fabPos, draggingFab, moveFab,
      period,
      periodSelected, yearSelected,
      exportPdf
    }
  }
}
</script>