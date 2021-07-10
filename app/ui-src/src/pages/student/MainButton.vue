<template>
  <div class="col-12 col-md-3">
    <div class="q-gutter-xs mobile-hide">
      <q-btn color="deep-purple" icon="add" class="q-pl-sm" :label="getLang.tambah"
        @click="showAddForm" />
      <q-btn color="negative" icon="delete" class="q-pl-sm" :label="getLang.hapus" 
        @click="multipleDeleteConfirm(getLang)" />
    </div>

    <q-page-sticky position="bottom-right" 
      :offset="fabPos" 
      class="mobile-only force-elevated"
      v-if="!$store.state.student.showAddForm">
      <q-btn fab icon="add" color="deep-purple" 
        @click="showAddForm" 
        v-if="selected.length === 0"
      />
      <q-btn fab icon="delete" color="negative" 
        @click="multipleDeleteConfirm(getLang)" 
        v-if="selected.length > 0"
      />
    </q-page-sticky>

  </div>
</template>

<script>
import { inject, computed } from 'vue'
import { useStore, mapMutations } from 'vuex'
import { flashAlert } from 'src/composables/notify'
import { fabPos } from 'src/composables/fab'

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
      showAddForm,
      selected: computed(() => store.state.student.selectedStudents),
      fabPos
    }
  }
}
</script>