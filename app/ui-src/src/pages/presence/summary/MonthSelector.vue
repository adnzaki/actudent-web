<template>
  <div class="col-12 col-sm-3 col-md-3 q-mt-sm q-px-xs">
    <q-select
      outlined
      v-model="period.month"
      :options="monthOptions"
      dense
      @update:model-value="monthSelected"
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
      @click="$store.dispatch('presence/getMonthlySummary')" />
  </div>
  <q-page-sticky position="bottom-right" 
    :offset="fabPos" 
    class="force-elevated">
    <q-fab color="secondary" 
      icon="print" direction="up" 
      :disable="draggingFab"
      v-touch-pan.prevent.mouse="moveFab">
      <q-btn icon="picture_as_pdf" 
        color="indigo"
        round 
        :href="exportPdf()" target="_blank">
        <btn-tooltip :label="$t('absensi_print_pdf')" anchor="center left" self="center end" />
      </q-btn>
      <q-btn icon="table_view" 
        color="blue"
        round 
        :href="exportExcel()" target="_blank">
        <btn-tooltip :label="$t('absensi_export_excel')" anchor="center left" self="center end" />
      </q-btn>
    </q-fab>
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
  name: 'MonthSelector',
  setup() {
    const { t } = useI18n()
    const store = useStore()
    const monthOptions = ref([])
    const period = ref({})
    const route = useRoute()
    const $q = useQuasar()

    const monthSelected = model => {
      store.state.presence.selectedPeriod.month = model.value
    }

    const yearSelected = model => {
      store.state.presence.selectedPeriod.year = model
    } 

    store.state.presence.selectedPeriod.month = '1'
    store.state.presence.selectedPeriod.year = 2022

    setTimeout(() => {
      period.value = {
        month: { label: t('mon1'), value: '1' },
        year: 2022
      }

      monthOptions.value = [
        { label: t('mon1'), value: '1' },
        { label: t('mon2'), value: '2' },
        { label: t('mon3'), value: '3' },
        { label: t('mon4'), value: '4' },
        { label: t('mon5'), value: '5' },
        { label: t('mon6'), value: '6' },
        { label: t('mon7'), value: '7' },
        { label: t('mon8'), value: '8' },
        { label: t('mon9'), value: '9' },
        { label: t('mon10'), value: '10' },
        { label: t('mon11'), value: '11' },
        { label: t('mon12'), value: '12' },
      ]
    }, 1500)  

    const gradeId = route.params.id
    const token = $q.cookies.get(conf.cookieName)

    const exportExcel = () => {
      return `${conf.adminAPI}absensi/excel-rekap-bulanan/` +
              `${store.state.presence.selectedPeriod.month}/` +
              `${store.state.presence.selectedPeriod.year}/` +
              `${gradeId}/${token}`
    }

    const exportPdf = () => {
      return `${conf.adminAPI}absensi/ekspor-rekap-bulanan/` +
              `${store.state.presence.selectedPeriod.month}/` +
              `${store.state.presence.selectedPeriod.year}/` +
              `${gradeId}/${token}`

    }

    return {
      monthOptions,
      yearOptions: [2020, 2021, 2022],
      fabPos, draggingFab, moveFab,
      period,
      monthSelected, yearSelected,
      exportExcel, exportPdf
    }
  }
}
</script>