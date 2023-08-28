<template>
  <div class="col-12 col-md-4">
    <div class="q-gutter-xs mobile-hide">
      <q-btn
        icon="add"
        :class="['q-pl-sm', addButton]"
        unelevated
        :label="$t('tambah')"
        @click="store.showAddForm = true"
      />
      <q-btn
        icon="delete"
        class="q-pl-sm delete-btn"
        unelevated
        :label="$t('hapus')"
        @click="multipleDeleteConfirm"
      />
    </div>

    <q-page-sticky
      position="bottom-right"
      :offset="fabPos"
      class="mobile-only force-elevated"
      v-if="!store.showAddForm"
    >
      <q-btn
        fab
        icon="add"
        :class="addButton"
        @click="store.showAddForm = true"
        v-if="selected.length === 0"
      />
      <q-btn
        fab
        icon="delete"
        class="delete-btn"
        @click="multipleDeleteConfirm"
        v-if="selected.length > 0"
      />
    </q-page-sticky>
  </div>
</template>

<script>
import { computed } from 'vue'
import { fabPos } from 'src/composables/fab'
import { useParentStore } from 'src/stores/parent'
import { addButton } from 'src/composables/mode'

export default {
  setup() {
    const store = useParentStore()

    return {
      store,
      addButton,
      selected: computed(() => store.selectedParents),
      multipleDeleteConfirm: () => store.multipleDeleteConfirm(),
      fabPos,
    }
  },
}
</script>
