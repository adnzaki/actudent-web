<template>
  <div class="row">
    <div class="col-6 q-pr-xs">
      <q-select
        outlined
        v-model="period.month"
        :options="monthOptions"
        dense
        @update:model-value="monthSelected"
      />
    </div>
    <div class="col-6 q-pl-xs">
      <q-select
        outlined
        v-model="period.year"
        :options="yearOptions"
        dense
        @update:model-value="yearSelected"
      />
    </div>
  </div>
</template>
<script>
import { ref } from 'vue'
import { useStore } from 'vuex'
import { useQuasar, date } from 'quasar'
import { conf, monthList, t } from 'src/composables/common'

export default {
  name: 'MonthSelector',
  setup() {
    const store = useStore()
    const monthOptions = ref([])
    const period = ref({})
    const $q = useQuasar()

    const selectedPeriod = ref(date.formatDate(new Date, 'MM-YYYY'))
    store.state.siabsen.period = selectedPeriod.value

    const getEvents = () => {
        
    }    
    
    getEvents()

    const monthSelected = model => {
      selectedPeriod.value = `${model.value}-${period.value.year}`
      store.state.siabsen.period = selectedPeriod.value
      getEvents()
    }

    const yearSelected = model => {
      selectedPeriod.value = `${period.value.month.value}-${model}`
      store.state.siabsen.period = selectedPeriod.value
      getEvents()
    } 

    setTimeout(() => {
      let monthNum = parseInt(selectedPeriod.value.substring(0, 2))
      period.value = {
        month: { label: t('mon' + monthNum), value: monthNum },
        year: 2022
      }

      monthOptions.value = monthList()
    }, 1500)  

    return {
      monthOptions,
      yearOptions: [2020, 2021, 2022],
      period,
      monthSelected, yearSelected,
    }
  }
}
</script>