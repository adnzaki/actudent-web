<template>
  <div class="col-12 col-md-4 q-gutter-xs">
    <q-btn color="deep-purple" icon="add" :label="lang.tambah" />
    <q-btn color="negative" icon="delete" :label="lang.hapus" />
  </div>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
  name: 'MainButton',
  props: ['lang'],
  setup() {
    return {}
  }
})
</script>