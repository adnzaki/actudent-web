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
      @update:model-value="selectedHandler"
      :label="label"
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
import { computed, ref, watch } from 'vue'
import { useStore } from 'vuex'

export default {
  name: 'DropdownSearch',
  props: [
    'vuexModule', 
    'selected', 
    'loader', // provide only if loadOnRoute is not defined
    'labelAsOption', // use option to be a label, "label" prop will be overriden if it is used
    'label',  // standard QSelect label
    'list', 
    'optionsValue', 
    'flexGrid', // add one or more grid classes to make component responsive
    'param', // add 1 optional parameter if needed
    'loadOnRoute', // load data that to be fetched on route enter
    'default', // default selected option -> useful when displaying in edit form
  ],

  setup(props) {
    const options = ref([])
    const model = ref({})
    const stringOptions = ref([])     
    const store = useStore()

    let selectedHandler

    if(typeof props.selected === 'string') {
      selectedHandler = model => store.dispatch(`${props.vuexModule}/${props.selected}`, model)
    } else {
      selectedHandler = props.selected
    }

    let modelValue = null

    if(props.default !== undefined) {
      modelValue = {
        label: props.default.label,
        value: props.default.value
      }
    } else {
      if(props.label === undefined) {
        modelValue = {
          label: props.labelAsOption,
          value: null
        }
      }
    }

    model.value = modelValue      

    stringOptions.value = [modelValue]

    const getList = async () => {
      if(props.loadOnRoute === undefined) {
        if(props.param !== undefined) {
          store.commit(`${props.vuexModule}/${props.loader}`, props.param)
        } else {
          store.commit(`${props.vuexModule}/${props.loader}`)
        }  
      }

      return new Promise((resolve, reject) => setTimeout(resolve, 100))
    }

    getList().then(async () => {
      const optionsList = computed(() => props.list)
      const pushOptions = async () => {        
        stringOptions.value = []
        await optionsList.value.forEach(item => {
          stringOptions.value.push({
            label: item[props.optionsValue.label],
            value: item[props.optionsValue.value]
          })
        }) 

        model.value = stringOptions.value[0]
      }

      await pushOptions()      
      watch(optionsList, pushOptions)

      // filter duplicate values, remove them if exist
      const filter = item => [item['value'], item]
      options.value = [...new Map(stringOptions.value.map(filter)).values()]      

    })

    return {
      options,
      model,
      filterFn(val, update, abort) {
        update(() => {
          const needle = val.toLowerCase()
          options.value = stringOptions.value.filter(v => {
            if(v !== null) {
              return v.label.toLowerCase().indexOf(needle) > -1
            }
          })
        })
      },
      selectedHandler
    }
  } 
}
</script>