<template>
  <div class="col-12 col-md-3 q-mt-sm">
    <q-select
      outlined
      v-model="model"
      :options="options"
      dense
      @update:model-value="getEmployeeByType"
    />
  </div>
</template>

<script>
import { ref } from 'vue'
import { useI18n } from 'vue-i18n'
import { useEmployeeStore } from 'src/stores/employee'

export default {
  setup() {
    const model = ref({})
    const { t } = useI18n()
    const options = ref([])
    const store = useEmployeeStore()
    
    setTimeout(() => {
      options.value = [
        { label: t('staff_semua_bagian'), value: 'null' },
        { label: t('staff_guru'), value: 'teacher' },
        { label: 'Staff', value: 'staff' }
      ]

      model.value = { 
        label: t('staff_semua_bagian'), value: 'null' 
      }
      
    }, 1500)


    return {
      model,
      options,
      getEmployeeByType: model => store.getEmployeeByType(model),
    }
  } 
}
</script>