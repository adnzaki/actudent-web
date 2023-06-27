<template>
  <div class="col-12 col-md-3">
    <div class="q-gutter-xs mobile-hide">
      <q-btn color="deep-purple" icon="add" class="q-pl-sm" :label="$t('tambah')"
        @click="store.showAddForm = true" />
      <q-btn color="negative" icon="delete" class="q-pl-sm" :label="$t('hapus')" 
        @click="multipleDeleteConfirm" />
    </div>

    <q-page-sticky position="bottom-right" 
      :offset="fabPos" 
      class="mobile-only force-elevated"
      v-if="!store.showAddForm">
      <q-btn fab icon="add" color="deep-purple" 
        @click="store.showAddForm = true" 
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
import { fabPos } from 'src/composables/fab'
import { useEmployeeStore } from 'src/stores/employee'

export default {
  setup() {
    const store = useEmployeeStore()
    
    return {
      store,
      fabPos,
      selected: computed(() => store.selectedEmployees),
      multipleDeleteConfirm: () => store.multipleDeleteConfirm(),
    }
  }
}
</script>