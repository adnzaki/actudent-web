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
import { useI18n } from 'vue-i18n'
import { ref } from 'vue'
import { mapActions } from 'vuex'

export default {
  name: 'EmployeeType',
  methods: {
    ...mapActions('employee', ['getEmployeeByType']),
  },
  setup() {
    const { t } = useI18n()
    const options = ref([])
    const model = ref({})
    
    setTimeout(() => {
      options.value = [
        { label: t('staff_semua_bagian'), value: 'null' },
        { label: t('staff_guru'), value: 'teacher' },
        { label: 'Staff', value: 'staff' }
      ]

      model.value = { 
        label: t('staff_semua_bagian'), value: 'null' 
      }
      
    }, 1500);


    return {
      options,
      model,
    }
  } 
}
</script>