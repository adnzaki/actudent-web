<template>
  <div class="col-6 col-md-2 q-mt-md q-pr-xs">
    <q-select
      outlined
      v-model="period.month"
      :options="monthOptions"
      dense
      @update:model-value="monthSelected"
    />
  </div>
  <div class="col-6 col-md-2 q-mt-md q-pl-xs">
    <q-select
      outlined
      v-model="period.year"
      :options="yearOptions"
      dense
      @update:model-value="yearSelected"
    />
  </div>
  <div class="col-12 col-md-2 q-mt-md q-px-xs mobile-hide">
    <q-btn color="secondary" 
      style="width: 100%; padding-top: 7.5px; padding-bottom: 7.5px;" 
      icon="print" 
      :label="$t('absensi_print_pdf')"
      :href="exportPdf()" target="_blank" />
  </div>
  <q-page-sticky position="bottom-right" 
    :offset="fabPos" 
    class="mobile-only force-elevated">
    <q-btn fab icon="print" color="secondary" 
      :href="exportPdf()" target="_blank" />    
  </q-page-sticky>
</template>
<script>
import { ref } from 'vue'
import { useStore } from 'vuex'
import { useQuasar, date } from 'quasar'
import { fabPos, draggingFab, moveFab } from 'src/composables/fab'
import { conf, monthList, t } from 'src/composables/common'

export default {
  setup() {
    const store = useStore()
    const monthOptions = ref([])
    const period = ref({})
    const $q = useQuasar()

    const selectedPeriod = ref(date.formatDate(new Date, 'MM-YYYY'))
    store.state.siabsen.period = selectedPeriod.value

    const getDetailPresence = () => {
      store.commit('siabsen/getDetailPresence', {
        staffId: 'null', 
        userId: 'null',
        period: store.state.siabsen.period
      })   
    }    
    
    getDetailPresence()

    const monthSelected = model => {
      selectedPeriod.value = `${model.value}-${period.value.year}`
      store.state.siabsen.period = selectedPeriod.value
      getDetailPresence()
    }

    const yearSelected = model => {
      selectedPeriod.value = `${period.value.month.value}-${model}`
      store.state.siabsen.period = selectedPeriod.value
      getDetailPresence()
    } 

    setTimeout(() => {
      let monthNum = parseInt(selectedPeriod.value.substring(0, 2))
      period.value = {
        month: { label: t('mon' + monthNum), value: monthNum },
        year: 2022
      }

      monthOptions.value = monthList()
    }, 1500)  

    const token = $q.cookies.get(conf.cookieName)

    const exportPdf = () => {
      return `${conf.siabsenAPI}print-rekap-individu/null/null/` + 
             `${store.state.siabsen.period}/${$q.cookies.get(conf.cookieName)}`
    }

    return {
      monthOptions,
      yearOptions: [2020, 2021, 2022],
      fabPos, draggingFab, moveFab,
      period,
      monthSelected, yearSelected,
      exportPdf
    }
  }
}
</script>