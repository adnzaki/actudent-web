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
    <q-btn color="deep-purple" 
      style="width: 100%; padding-top: 7.5px; padding-bottom: 7.5px;"
      icon="preview" 
      :label="$t('tampilkan')"
      @click="$store.dispatch('presence/getPeriodSummary')" />
  </div>

  <q-page-sticky position="bottom-right" :offset="fabPos" class="force-elevated">
    <q-btn fab icon="print" color="secondary" 
      :href="exportPdf()" target="_blank" />    
  </q-page-sticky>
</template>
<script>
import { ref, computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { useStore } from 'vuex'
import { useRoute } from 'vue-router'
import { useQuasar } from 'quasar'
import { fabPos, draggingFab, moveFab, singlePos } from 'src/composables/fab'
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
    const currentYear = new Date().getFullYear()
    const currentMonth = new Date().getMonth()

    fabPos.value = [ singlePos, singlePos ]

    const periodSelected = model => {
      store.state.presence.selectedPeriod.semester = model.value
    }

    const yearSelected = model => {
      store.state.presence.selectedPeriod.year = model.value
    } 

    // if the current month is between January to June (0-5 in JS date)
    // then it is the first semester, otherwise it is 2nd semester
    store.state.presence.selectedPeriod.semester = currentMonth < 6 ? '2' : '1'
    
    // current active year
    store.state.presence.selectedPeriod.year = currentYear - 1

    setTimeout(() => {
      const periodLabel = computed(() => {
        return store.state.presence.selectedPeriod.semester === '1'
          ? t('ganjil') : t('genap')
      }) 

      period.value = {
        semester: { label: periodLabel.value, value: store.state.presence.selectedPeriod.semester },
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

    const yearOptions = () => {
      const currentPeriod = currentYear - 1
      const previousPeriod = currentYear - 2

      return [
        { label: t(`${previousPeriod}/${currentPeriod}`), value: previousPeriod },
        { label: t(`${currentPeriod}/${currentYear}`), value: currentPeriod },
      ]
    }

    return {
      periodOptions,
      yearOptions: yearOptions(),
      fabPos, draggingFab, moveFab,
      period,
      periodSelected, yearSelected,
      exportPdf
    }
  }
}
</script>