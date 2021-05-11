<template>
  <div :class="rootClass">
    <q-input outlined bottom-slots v-model="$store.state[vuexModule]['paging']['search']" 
      :label="label"
      @keyup.enter="filter"
      dense>
      <template v-slot:append>
        <q-icon name="search" @click="filter" class="cursor-pointer" />
      </template>
    </q-input>
  </div>
</template>

<script>
import { computed, watch } from 'vue'
import { useStore } from 'vuex'

export default {
  name: 'SearchBox',
  props: {
    label: {
      type: String
    },
    rootClass: {
      type: String,
      default: 'col-12 col-md-4'
    },
    vuexModule: {
      type: String,
      required: true,
    }
  },
  setup(props) {
    const $store = useStore()
    let search = computed(() => $store.state[props.vuexModule]['paging']['search'])
    watch(search, () => $store.dispatch(`${props.vuexModule}/onSearchChanged`))

    return {
      filter: () => $store.dispatch(`${props.vuexModule}/filter`)
    }
  }
}
</script>