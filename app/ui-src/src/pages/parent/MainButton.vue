<template>
  <div class="col-12 col-md-4 q-gutter-xs">
    <q-btn color="deep-purple" icon="add" :label="lang.tambah"
      @click="$store.state.parent.showAddForm = true" />
    <q-btn color="negative" icon="delete" :label="lang.hapus" 
      @click="multipleDeleteConfirm(lang)" />
  </div>
</template>

<script>
import { mapMutations } from 'vuex'
export default {
  name: 'MainButton',
  props: ['lang'],
  methods: {
    ...mapMutations('parent', ['multipleDeleteConfirm'])
  },
  setup() {
    return {}
  }
}
</script>