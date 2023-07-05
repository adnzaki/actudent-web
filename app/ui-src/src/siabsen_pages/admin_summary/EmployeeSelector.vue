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
import { useSiabsenStore } from 'src/stores/siabsen'

export default {
  setup() {
    const { t } = useI18n()
    const options = ref([])
    const model = ref({})
    const $q = useQuasar()
    const store = useSiabsenStore()

    const allStaffValue = 'null'

    store.employeeFilter = allStaffValue

    setTimeout(() => {
      options.value = [
        { label: t('staff_semua_bagian'), value: allStaffValue },
        { label: t('staff_guru'), value: 'teacher' },
        { label: 'Staff', value: 'staff' },
      ]

      model.value = {
        label: t('staff_semua_bagian'),
        value: allStaffValue,
      }

      store
        .getAllStaffSummary({
          start: store.dateRangeStart,
          end: store.dateRangeEnd,
          type: store.employeeFilter,
        })
        .then(() => (store.spinner = false))
    }, 1500)

    return {
      width: () => ($q.screen.lt.md ? '100%' : '95%'),
      modelChanged(model) {
        store.employeeFilter = model.value
        store
          .getAllStaffSummary({
            start: store.dateRangeStart,
            end: store.dateRangeEnd,
            type: store.employeeFilter,
          })
          .then(() => (store.spinner = false))
      },
      options,
      model,
    }
  },
}
</script>
