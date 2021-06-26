<template>
  <div class="col-12 col-md-3 q-gutter-xs">
    <q-btn color="deep-purple" icon="add" class="q-pl-sm" :label="getLang.tambah"
       />
    <q-btn color="negative" icon="delete" class="q-pl-sm" :label="getLang.hapus" 
       />
  </div>
</template>

<script>
import { mapMutations } from 'vuex'

export default {
  name: 'MainButton',
  inject: ['textLang'],
  computed: {
    getLang() {
      return this.textLang.value
    }
  }
}
</script>