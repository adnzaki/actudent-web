<template>
  <div class="col-12 col-sm-4 col-md-3 q-mt-sm q-px-xs">
    <q-select
      outlined
      v-model="period.semester"
      :options="periodOptions"
      dense
      @update:model-value="periodSelected"
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
      color="deep-purple"
      style="width: 100%; padding-top: 7.5px; padding-bottom: 7.5px"
      icon="preview"
      :label="$t('tampilkan')"
      @click="store.getPeriodSummary()"
    />
  </div>

  <q-page-sticky
    position="bottom-right"
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
</template>
<script>
import { useI18n } from 'vue-i18n'
import { useQuasar } from 'quasar'
import { ref, computed } from 'vue'
import { useRoute } from 'vue-router'
import { conf } from 'src/composables/common'
import { usePresenceStore } from 'src/stores/presence'
import { fabPos, draggingFab, moveFab, singlePos } from 'src/composables/fab'

export default {
  name: 'PeriodSelector',
  setup() {
    const $q = useQuasar()
    const period = ref({})
    const { t } = useI18n()
    const route = useRoute()
    const periodOptions = ref([])
    const store = usePresenceStore()
    const currentMonth = new Date().getMonth()
    const currentYear = new Date().getFullYear()

    fabPos.value = [singlePos, singlePos]

    const periodSelected = (model) => {
      store.selectedPeriod.semester = model.value
    }

    const yearSelected = (model) => {
      store.selectedPeriod.year = model.value
    }

    // if the current month is between January to June (0-5 in JS date)
    // then it is the first semester, otherwise it is 2nd semester
    store.selectedPeriod.semester = currentMonth < 6 ? '2' : '1'

    // current active year
    store.selectedPeriod.year = currentYear

    setTimeout(() => {
      const periodLabel = computed(() => {
        return store.selectedPeriod.semester === '1' ? t('ganjil') : t('genap')
      })

      period.value = {
        semester: {
          label: periodLabel.value,
          value: store.selectedPeriod.semester,
        },
        year: { label: '2023/2024', value: store.selectedPeriod.year },
      }

      periodOptions.value = [
        { label: t('ganjil'), value: '1' },
        { label: t('genap'), value: '2' },
      ]
    }, 1500)

    const token = $q.cookies.get(conf.cookieName)

    const exportPdf = () => {
      return (
        `${conf.adminAPI}absensi/ekspor-rekap-semester/` +
        `${route.params.id}/` +
        `${store.selectedPeriod.semester}/` +
        `${store.selectedPeriod.year}/${token}`
      )
    }

    return {
      store,
      period,
      exportPdf,
      periodOptions,
      fabPos,
      draggingFab,
      moveFab,
      periodSelected,
      yearSelected,
      yearOptions: [
        { label: '2021/2022', value: 2021 },
        { label: '2022/2023', value: 2022 },
        { label: '2023/2024', value: 2023 },
      ],
    }
  },
}
</script>
