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
      v-if="!store.showAddForm">
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
import { computed } from 'vue'
import { flashAlert } from 'src/composables/notify'
import { fabPos } from 'src/composables/fab'
import { useStudentStore } from 'src/stores/student'
import { t } from 'src/composables/common'

export default {
  setup() {
    const store = useStudentStore()
    
    const showAddForm = () => {
      if(store.studentLimit === 'allowed') {
        store.showAddForm = true
      } else {
        flashAlert(t('value.siswa_overlimit'), 'negative')
      }
    }

    return {
      store,
      multipleDeleteConfirm: () => store.multipleDeleteConfirm(),
      showAddForm,
      selected: computed(() => store.selectedStudents),
      fabPos
    }
  }
}
</script>