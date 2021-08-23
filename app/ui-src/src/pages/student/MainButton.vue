<template>
  <div class="col-12 col-md-3">
    <div class="q-gutter-xs mobile-hide">
      <q-btn color="deep-purple" icon="add" class="q-pl-sm" :label="$t('tambah')"
        @click="showAddForm" />
      <q-btn color="negative" icon="delete" class="q-pl-sm" :label="$t('hapus')" 
        @click="multipleDeleteConfirm" />
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
        @click="multipleDeleteConfirm" 
        v-if="selected.length > 0"
      />
    </q-page-sticky>

  </div>
</template>

<script>
import { useI18n } from 'vue-i18n'
import { computed } from 'vue'
import { useStore, mapMutations } from 'vuex'
import { flashAlert } from 'src/composables/notify'
import { fabPos } from 'src/composables/fab'

export default {
  name: 'MainButton',
  methods: {
    ...mapMutations('student', ['multipleDeleteConfirm'])
  },
  setup() {
    const t = useI18n()
    const store = useStore()
    
    const showAddForm = () => {
      if(store.state.student.studentLimit === 'allowed') {
        store.state.student.showAddForm = true
      } else {
        flashAlert(t('value.siswa_overlimit'), 'negative')
      }
    }

    return {
      showAddForm,
      selected: computed(() => store.state.student.selectedStudents),
      fabPos
    }
  }
}
</script>