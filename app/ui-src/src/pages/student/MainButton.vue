<template>
  <div class="col-12 col-md-3">
    <div class="q-gutter-xs mobile-hide">
      <q-btn
        icon="add"
        unelevated
        :class="['q-pl-sm', addButton]"
        :label="$t('tambah')"
        @click="showAddForm"
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
        @click="showAddForm"
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
import { flashAlert } from 'src/composables/notify'
import { fabPos } from 'src/composables/fab'
import { useStudentStore } from 'src/stores/student'
import { t, addButton } from 'src/composables/common'

export default {
  setup() {
    const store = useStudentStore()

    const showAddForm = () => {
      if (store.studentLimit === 'allowed') {
        store.showAddForm = true
      } else {
        flashAlert(t('value.siswa_overlimit'), 'negative')
      }
    }

    return {
      store,
      fabPos,
      addButton,
      showAddForm,
      multipleDeleteConfirm: () => store.multipleDeleteConfirm(),
      selected: computed(() => store.selectedStudents),
    }
  },
}
</script>
