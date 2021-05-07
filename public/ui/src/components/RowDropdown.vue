<template>
  <div :class="['col-12 col-md-2 offset-md-2', addClass]" style="padding-right: 10px;">
    <q-select outlined v-model="$store.state[vuexModule]['paging']['rows']" 
      :options="options" dense
      @update:model-value="showPerPage"
      :display-value="`${$store.state[vuexModule]['paging']['rows']} ${lang.baris}`" 
    />
  </div>
</template>

<script>
import { defineComponent } from 'vue'
import { useStore } from 'vuex'

export default defineComponent({
  name: 'RowDropdown',
  props: ['lang', 'addClass', 'vuexModule'],
  setup(props) {
    const $store = useStore()
    const options = [10, 25, 50, 100, 250]

    return {
      options,
      showPerPage: () => $store.dispatch(`${props.vuexModule}/showPerPage`)
    }
  }
})
</script>