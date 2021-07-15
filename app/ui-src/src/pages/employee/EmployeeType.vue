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
import { inject, computed, ref } from 'vue'
import { mapActions } from 'vuex'

export default {
  name: 'EmployeeType',
  methods: {
    ...mapActions('employee', ['getEmployeeByType']),
  },
  setup() {
    const getLang = computed(() => inject('textLang')).value
    const options = ref([])
    const model = ref({})
    
    setTimeout(() => {
      options.value = [
        { label: getLang.value.staff_semua_bagian, value: 'null' },
        { label: getLang.value.staff_guru, value: 'teacher' },
        { label: getLang.value.staff_pegawai, value: 'staff' }
      ]

      model.value = { 
        label: getLang.value.staff_semua_bagian, value: 'null' 
      }
      
    }, 1500);


    return {
      options,
      model,
    }
  } 
}
</script>