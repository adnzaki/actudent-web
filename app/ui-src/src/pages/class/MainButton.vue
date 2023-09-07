<template>
  <div class="col-12 col-md-5">
    <div class="q-gutter-xs">
      <q-btn
        icon="add"
        :class="['q-pl-sm mobile-hide', addButton]"
        unelevated
        :label="$t('tambah')"
        @click="store.showAddForm = true"
      />
      <q-btn
        icon="delete"
        class="q-pl-sm delete-btn mobile-hide"
        unelevated
        :label="$t('hapus')"
        @click="store.multipleDeleteConfirm()"
      />
      <q-btn
        icon="content_copy"
        :class="['q-pl-sm', addButton]"
        unelevated
        :label="$t('kelas_salin_rombel')"
        @click="$router.push('/class/copy-classgroup')"
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
        @click="store.multipleDeleteConfirm()"
        v-if="selected.length > 0"
      />
    </q-page-sticky>
  </div>
</template>

<script>
import { computed } from 'vue'
import { useClassStore } from 'src/stores/class'
import { fabPos } from 'src/composables/fab'
import { addButton } from 'src/composables/mode'

export default {
  name: 'MainButton',
  setup() {
    const store = useClassStore()
    return {
      store,
      addButton,
      selected: computed(() => store.selectedClasses),
      fabPos,
    }
  },
}
</script>
