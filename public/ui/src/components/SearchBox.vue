<template>
  <div :class="['col col-sm-6 col-md-4', addClass]">
    <q-input outlined bottom-slots v-model="$store.state[vuexModule]['paging']['search']" 
      :label="label"
      @keyup.enter="filter">
      <template v-slot:append>
        <q-icon name="search" @click="filter" class="cursor-pointer" />
      </template>
    </q-input>
  </div>
</template>

<script>
import { defineComponent, computed, watch } from 'vue'
import { mapActions, useStore } from 'vuex'

export default defineComponent({
  name: 'SearchBox',
  props: ['label', 'addClass', 'vuexModule'],
  methods: {
    ...mapActions('parent', [ 
      'filter'
    ])
  },
  setup(props) {
    const $store = useStore()
    let search = computed(() => $store.state[props.vuexModule]['paging']['search'])
    watch(search, () => $store.dispatch(`${props.vuexModule}/onSearchChanged`))

    return {}
  }
})
</script>