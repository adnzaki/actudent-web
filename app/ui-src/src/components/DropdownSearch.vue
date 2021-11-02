<template>
  <div :class="['col-12 q-mt-sm', flexGrid]">
    <q-select
      outlined
      v-model="model"
      use-input
      input-debounce="0"
      :options="options"
      dense
      @filter="filterFn"
      @update:model-value="updateHandler"
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
import { useI18n } from 'vue-i18n'
import { computed, ref } from 'vue'
import { useStore } from 'vuex'

export default {
  name: 'DropdownSearch',
  props: [
    'vuexModule', 
    'updated', 
    'loader', // provide only if loadOnRoute is not defined
    'label', 
    'list', 
    'optionsValue', 
    'flexGrid', // add one or more grid classes to make component responsive
    'param', // add 1 optional parameter if needed
    'loadOnRoute' // load data that to be fetched on route enter
  ],

  setup(props) {
    const { t } = useI18n()
    const options = ref([])
    const model = ref({})
    const stringOptions = ref([])     
    const store = useStore()
    const updateHandler = model => store.dispatch(`${props.vuexModule}/${props.updated}`, model)

    setTimeout(() => {    
      let modelValue = {
        label: props.label,
        value: 'null'
      }
  
      model.value = modelValue      

      stringOptions.value = [modelValue]

      if(props.loadOnRoute === undefined) {
        if(props.param !== undefined) {
          store.commit(`${props.vuexModule}/${props.loader}`, props.param)
        } else {
          store.commit(`${props.vuexModule}/${props.loader}`)
        }  
      }
  
      const optionsList = computed(() => props.list)

      setTimeout(() => {
        optionsList.value.forEach(item => {
          stringOptions.value.push({
            label: item[props.optionsValue.label],
            value: item[props.optionsValue.value]
          })
        }) 

        options.value = stringOptions.value       
      }, 1000)      
    }, 1000)

    return {
      options,
      model,
      filterFn(val, update, abort) {
        update(() => {
          const needle = val.toLowerCase()
          options.value = stringOptions.value.filter(v => v.label.toLowerCase().indexOf(needle) > -1)
        })
      },
      updateHandler
    }
  } 
}
</script>