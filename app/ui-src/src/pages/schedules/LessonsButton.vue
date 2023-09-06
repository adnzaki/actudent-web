<template>
  <div class="col-12">
    <div class="q-gutter-xs mobile-hide">
      <q-btn
        icon="add"
        unelevated
        :class="['q-pl-sm', addButton]"
        :label="$t('tambah')"
        @click="store.lesson.showAddForm = true"
      />
      <q-btn
        icon="delete"
        unelevated
        class="q-pl-sm delete-btn"
        :label="$t('hapus')"
        @click="store.multipleDeleteConfirm()"
      />
    </div>

    <q-page-sticky
      position="bottom-right"
      :offset="fabPos"
      class="mobile-only force-elevated"
    >
      <q-btn
        fab
        icon="add"
        :class="addButton"
        @click="store.lesson.showAddForm = true"
        v-if="selected.length === 0"
      />
      <q-btn
        fab
        icon="delete"
        class="delete-btn"
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
import { addButton } from 'src/composables/mode'

export default {
  name: 'LessonsButton',
  setup() {
    const store = useScheduleStore()

    return {
      store,
      fabPos,
      addButton,
      selected: computed(() => store.lesson.selected),
    }
  },
}
</script>
