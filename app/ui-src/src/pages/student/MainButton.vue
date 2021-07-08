<template>
  <div class="col-12 col-md-3 q-gutter-xs">
    <q-btn color="deep-purple" icon="add" class="q-pl-sm" :label="getLang.tambah"
      @click="showAddForm" />
    <q-btn color="negative" icon="delete" class="q-pl-sm" :label="getLang.hapus" 
       @click="multipleDeleteConfirm(getLang)" />
  </div>
</template>

<script>
import { inject, computed } from 'vue'
import { useStore, mapMutations } from 'vuex'
import { flashAlert } from 'src/composables/notify'

export default {
  name: 'MainButton',
  inject: ['textLang'],
  methods: {
    ...mapMutations('student', ['multipleDeleteConfirm'])
  },
  setup() {
    const store = useStore()
    const getLang = computed(() => inject('textLang')).value
    
    const showAddForm = () => {
      if(store.state.student.studentLimit === 'allowed') {
        store.state.student.showAddForm = true
      } else {
        flashAlert(getLang.value.siswa_overlimit, 'negative')
      }
    }

    return {
      getLang,
      showAddForm
    }
  }
}
</script>