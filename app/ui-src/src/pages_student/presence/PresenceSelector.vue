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
      :class="addButton"
      style="width: 100%; padding-top: 7.5px; padding-bottom: 7.5px"
      icon="preview"
      :label="$t('tampilkan')"
      @click="store.getMonthlyPresence"
    />
  </div>
</template>

<script setup>
import { ref, nextTick, watch, watchEffect } from 'vue'
import { useQuasar } from 'quasar'
import { addButton, t } from 'src/composables/common'
import { useMonitoringStore } from 'src/stores/monitoring.js'
import { lang } from 'src/i18n/fetch-lang'

const period = ref({})
const $q = useQuasar()
const monthOptions = ref([])

const store = useMonitoringStore()
const currentYear = new Date().getFullYear()
const currentMonth = new Date().getMonth()

watchEffect(() => {
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

  period.value = {
    month: {
      label: monthOptions.value[currentMonth].label,
      value: currentMonth + 1,
    },
    year: currentYear,
  }
})

const monthSelected = (model) => {
  store.selectedPeriod.month = model.value
}

const yearSelected = (model) => {
  store.selectedPeriod.year = model
}

store.selectedPeriod.month = currentMonth + 1
store.selectedPeriod.year = currentYear

const yearOptions = [
  currentYear - 3,
  currentYear - 2,
  currentYear - 1,
  currentYear,
]
</script>
