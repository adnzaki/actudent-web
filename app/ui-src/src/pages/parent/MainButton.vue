<template>
  <div class="col-12 col-md-4 q-gutter-xs">
    <q-btn color="deep-purple" icon="add" class="q-pl-sm" :label="getLang.tambah"
      @click="$store.state.parent.showAddForm = true" />
    <q-btn color="negative" icon="delete" class="q-pl-sm" :label="getLang.hapus" 
      @click="multipleDeleteConfirm(getLang)" />
  </div>
</template>

<script>
import { inject, computed } from 'vue'
import { mapMutations } from 'vuex'

export default {
  name: 'MainButton',
  methods: {
    ...mapMutations('parent', ['multipleDeleteConfirm'])
  },
  setup() {
    return {
      getLang: computed(() => inject('textLang')).value
    }
  }
}
</script>