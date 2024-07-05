<template>
  <div class="col-12 col-md-4">
    <div class="q-gutter-xs mobile-hide">
      <q-btn
        icon="add"
        unelevated
        :class="['q-pl-sm', addButton]"
        :label="$t('tambah')"
        @click="store.showForm = true"
      />
      <q-btn
        icon="delete"
        class="q-pl-sm delete-btn"
        unelevated
        :label="$t('hapus')"
        @click="store.multipleDeleteConfirm()"
      />
    </div>

    <q-page-sticky
      position="bottom-right"
      :offset="fabPos"
      class="mobile-only force-elevated"
      v-if="!store.showForm"
    >
      <q-btn
        fab
        icon="add"
        :class="addButton"
        @click="store.showForm = true"
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
import { useHolidaysStore } from 'src/stores/holidays'
import { addButton } from 'src/composables/mode'

export default {
  name: 'MainButton',
  setup() {
    const store = useHolidaysStore()

    return {
      store,
      addButton,
      selected: computed(() => store.selectedDays),
      fabPos,
    }
  },
}
</script>
