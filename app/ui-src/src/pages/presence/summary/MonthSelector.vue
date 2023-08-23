<template>
  <div class="col-12 col-sm-4 col-md-3 q-mt-sm q-px-xs">
    <q-select
      outlined
      v-model="period.month"
      :options="monthOptions"
      dense
      @update:model-value="monthSelected"
    />
  </div>
  <div class="col-12 col-sm-4 col-md-3 q-mt-sm q-px-xs">
    <q-select
      outlined
      v-model="period.year"
      :options="yearOptions"
      dense
      @update:model-value="yearSelected"
    />
  </div>
  <div class="col-12 col-sm-4 col-md-2 q-mt-sm q-px-xs">
    <q-btn
      class="add-btn"
      style="width: 100%; padding-top: 7.5px; padding-bottom: 7.5px"
      icon="preview"
      :label="$t('tampilkan')"
      @click="store.getMonthlySummary()"
    />
  </div>
  <q-page-sticky
    position="bottom-right"
    :offset="fabPos"
    class="force-elevated"
  >
    <q-fab
      color="secondary"
      icon="print"
      direction="up"
      :disable="draggingFab"
      v-touch-pan.prevent.mouse="moveFab"
    >
      <q-btn
        icon="picture_as_pdf"
        color="indigo"
        round
        :href="exportPdf()"
        target="_blank"
      >
        <btn-tooltip
          :label="$t('absensi_print_pdf')"
          anchor="center left"
          self="center end"
        />
      </q-btn>
      <q-btn
        icon="table_view"
        color="blue"
        round
        :href="exportExcel()"
        target="_blank"
      >
        <btn-tooltip
          :label="$t('absensi_export_excel')"
          anchor="center left"
          self="center end"
        />
      </q-btn>
    </q-fab>
  </q-page-sticky>
</template>
<script>
import { ref } from 'vue'
import { useQuasar } from 'quasar'
import { useI18n } from 'vue-i18n'
import { useRoute } from 'vue-router'
import { conf } from 'src/composables/common'
import { usePresenceStore } from 'src/stores/presence'
import { fabPos, draggingFab, moveFab } from 'src/composables/fab'

export default {
  name: 'MonthSelector',
  setup() {
    const period = ref({})
    const $q = useQuasar()
    const { t } = useI18n()
    const route = useRoute()
    const monthOptions = ref([])
    const store = usePresenceStore()
    const currentYear = new Date().getFullYear()

    const monthSelected = (model) => {
      store.selectedPeriod.month = model.value
    }

    const yearSelected = (model) => {
      store.selectedPeriod.year = model
    }

    store.selectedPeriod.month = '1'
    store.selectedPeriod.year = currentYear

    setTimeout(() => {
      period.value = {
        month: { label: t('mon1'), value: '1' },
        year: currentYear,
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
      return (
        `${conf.adminAPI}absensi/excel-rekap-bulanan/` +
        `${store.selectedPeriod.month}/` +
        `${store.selectedPeriod.year}/` +
        `${gradeId}/${token}`
      )
    }

    const exportPdf = () => {
      return (
        `${conf.adminAPI}absensi/ekspor-rekap-bulanan/` +
        `${store.selectedPeriod.month}/` +
        `${store.selectedPeriod.year}/` +
        `${gradeId}/${token}`
      )
    }

    return {
      store,
      period,
      monthOptions,
      exportExcel,
      exportPdf,
      monthSelected,
      yearSelected,
      fabPos,
      draggingFab,
      moveFab,
      yearOptions: [
        currentYear - 3,
        currentYear - 2,
        currentYear - 1,
        currentYear,
      ],
    }
  },
}
</script>
