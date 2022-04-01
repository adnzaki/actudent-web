<template>
  <div class="col-12">
    <div class="q-gutter-xs mobile-hide">
      <q-btn color="deep-purple" icon="add" class="q-pl-sm" :label="$t('tambah')"
        @click="$store.state.schedule.lesson.showAddForm = true" />
      <q-btn color="negative" icon="delete" class="q-pl-sm" :label="$t('hapus')"
        @click="$store.commit('schedule/multipleDeleteConfirm')" />
    </div>

    <q-page-sticky position="bottom-right" 
      :offset="fabPos" 
      class="mobile-only force-elevated">
      <q-fab color="primary" icon="keyboard_arrow_up" direction="up">
        <q-fab-action color="deep-purple" icon="add"
          @click="$store.state.schedule.lesson.showAddForm = true" />
        <q-fab-action color="negative" icon="delete"
          @click="$store.commit('schedule/multipleDeleteConfirm')" />
      </q-fab>
    </q-page-sticky>
  </div>
</template>

<script>
import { fabPos } from 'src/composables/fab'

export default {
  name: 'LessonsButton',
  setup() {
    
    return {
      fabPos,
    }
  }
}
</script>