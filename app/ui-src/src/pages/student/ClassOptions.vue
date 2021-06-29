<template>
  <div class="col-12 col-md-3 q-pr-xs q-mt-sm">
    <q-select
      outlined
      v-model="model"
      use-input
      input-debounce="0"
      :options="options"
      dense
      @filter="filterFn"
      @update:model-value="getStudentsByClass"
    >
      <template v-slot:no-option>
        <q-item>
          <q-item-section class="text-grey">
            No results
          </q-item-section>
        </q-item>
      </template>
    </q-select>
  </div>
</template>

<script>
import { inject, computed, ref } from 'vue'
import { mapActions, useStore } from 'vuex'

export default {
  name: 'ClassOptions',
  methods: {
    ...mapActions('student', ['getStudentsByClass']),
  },
  setup() {
    const options = ref([])
    const model = ref({})
    const stringOptions = ref([])     
    const store = useStore()
    const getLang = computed(() => inject('textLang')).value  

    setTimeout(() => {    
      let modelValue = {
        label: getLang.value.siswa_semua_kelas,
        value: 'null'
      }
  
      model.value = modelValue
      stringOptions.value = [modelValue]
  
      store.commit('student/getClassGroup')
  
      const classGroupList = computed(() => store.state.student.classGroupList)

      setTimeout(() => {
        classGroupList.value.forEach(item => {
          stringOptions.value.push({
            label: item.grade_name,
            value: item.grade_id
          })
        }) 

        options.value = stringOptions.value       
      }, 2000);
      
    }, 3000);
    return {
      options,
      model,
      filterFn(val, update, abort) {
        update(() => {
          const needle = val.toLowerCase()
          options.value = stringOptions.value.filter(v => v.label.toLowerCase().indexOf(needle) > -1)
        })
      }
    }
  } 
}
</script>