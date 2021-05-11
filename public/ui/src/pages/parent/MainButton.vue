<template>
  <div class="col-12 col-md-4 q-gutter-xs">
    <q-btn color="deep-purple" icon="add" :label="lang.tambah"
      @click="$store.state.parent.showAddForm = true" />
    <q-btn color="negative" icon="delete" :label="lang.hapus" />
  </div>
</template>

<script>
export default {
  name: 'MainButton',
  props: ['lang'],
  setup() {
    return {}
  }
}
</script>