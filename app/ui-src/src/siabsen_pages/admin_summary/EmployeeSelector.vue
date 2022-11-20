<template>
  <div class="col-12 col-md-3 q-mt-md q-px-xs">
    <q-select
      :style="{ width: width() }"
      outlined
      v-model="model"
      :options="options"
      dense
      @update:model-value="modelChanged"
    />
  </div>
</template>

<script>
import { useI18n } from 'vue-i18n'
import { ref } from 'vue'
import { useQuasar } from 'quasar'
import { useStore } from 'vuex'

export default {
  setup() {
    const { t } = useI18n()
    const options = ref([])
    const model = ref({})
    const $q = useQuasar()
    const store = useStore()

    const allStaffValue = 'null'

    store.state.siabsen.employeeFilter = allStaffValue
    
    setTimeout(() => {
      options.value = [
        { label: t('staff_semua_bagian'), value: allStaffValue },
        { label: t('staff_guru'), value: 'teacher' },
        { label: 'Staff', value: 'staff' }
      ]

      model.value = { 
        label: t('staff_semua_bagian'), value: allStaffValue
      }
            
      store.dispatch('siabsen/getAllStaffSummary', {
        start: store.state.siabsen.dateRangeStart,
        end: store.state.siabsen.dateRangeEnd,
        type: store.state.siabsen.employeeFilter
      }).then(() => store.state.siabsen.spinner = false)

    }, 1500);


    return {
      width: () => $q.screen.lt.md ? '100%' : '95%',
      modelChanged(model) {
        store.state.siabsen.employeeFilter = model.value
        store.dispatch('siabsen/getAllStaffSummary', {
          start: store.state.siabsen.dateRangeStart,
          end: store.state.siabsen.dateRangeEnd,
          type: store.state.siabsen.employeeFilter
        }).then(() => store.state.siabsen.spinner = false)
      },
      options,
      model,
    }
  } 
}
</script>