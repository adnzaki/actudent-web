<template>
  <div class="col-12">
    <div class="q-gutter-xs mobile-hide">
      <q-btn color="deep-purple" icon="add" class="q-pl-sm" :label="$t('tambah')"
        @click="store.lesson.showAddForm = true" />
      <q-btn color="negative" icon="delete" class="q-pl-sm" :label="$t('hapus')"
        @click="store.multipleDeleteConfirm()" />
    </div>

    <q-page-sticky position="bottom-right" 
      :offset="fabPos" 
      class="mobile-only force-elevated">
      <q-btn fab icon="add" color="deep-purple" 
        @click="store.lesson.showAddForm = true" 
        v-if="selected.length === 0"
      />
      <q-btn fab icon="delete" color="negative" 
        @click="store.multipleDeleteConfirm()" 
        v-if="selected.length > 0"
      />
    </q-page-sticky>
  </div>
</template>

<script>
import { computed } from 'vue'
import { fabPos } from 'src/composables/fab'
import { useScheduleStore } from 'src/stores/schedule'

export default {
  name: 'LessonsButton',
  setup() {
    const store = useScheduleStore()
    
    return { 
      store,
      selected: computed(() => store.lesson.selected),
      fabPos,
    }
  }
}
</script>