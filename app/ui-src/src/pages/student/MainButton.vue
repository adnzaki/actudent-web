<template>
  <div class="col-12 col-md-3 q-gutter-xs">
    <q-btn color="deep-purple" icon="add" class="q-pl-sm" :label="getLang.tambah"
      @click="$store.state.student.showAddForm = true" />
    <q-btn color="negative" icon="delete" class="q-pl-sm" :label="getLang.hapus" 
       @click="multipleDeleteConfirm(getLang)" />
  </div>
</template>

<script>
import { mapMutations } from 'vuex'

export default {
  name: 'MainButton',
  inject: ['textLang'],
  methods: {
    ...mapMutations('student', ['multipleDeleteConfirm'])
  },
  computed: {
    getLang() {
      return this.textLang.value
    }
  }
}
</script>