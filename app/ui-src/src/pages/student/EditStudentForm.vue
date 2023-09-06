<template>
  <q-dialog
    no-backdrop-dismiss
    v-model="store.showEditForm"
    @hide="formClose"
    :maximized="maximizedDialog()"
  >
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ $t('siswa_add_title') }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">
          <q-input
            outlined
            :label="$t('siswa_nis')"
            minlength="9"
            maxlength="10"
            dense
            v-model="store.detail.student_nis"
          />
          <ac-error :label="error.student_nis" />

          <q-input
            outlined
            :label="$t('siswa_nama')"
            dense
            v-model="store.detail.student_name"
          />
          <ac-error :label="error.student_name" />

          <search-parents />
        </q-form>
      </q-card-section>
      <q-separator />
      <q-card-actions align="right">
        <q-btn
          flat
          :label="$t('tutup')"
          v-if="!$q.screen.lt.sm"
          color="negative"
          v-close-popup
          class="close-btn"
        />
        <q-btn
          :label="$t('simpan')"
          class="mobile-form-btn save-btn"
          unelevated
          :disable="disableSaveButton"
          @click="save"
        />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { computed } from 'vue'
import SearchParents from './SearchParents.vue'
import { useStudentStore } from 'src/stores/student'
import { maximizedDialog, cardDialog } from '../../composables/screen'

export default {
  components: { SearchParents },
  setup() {
    const store = useStudentStore()
    const selectedParent = computed(() => store.selectedParent)

    const save = () => {
      store.detail.parent_id = selectedParent.value.id
      store.save({
        data: store.detail,
        edit: true,
        id: store.detail.student_id,
      })
    }

    const formClose = () => {
      store.selectedParent = {
        id: '',
        father: '',
        mother: '',
      }
    }

    return {
      save,
      store,
      formClose,
      maximizedDialog,
      cardDialog,
      error: computed(() => store.error),
      disableSaveButton: computed(() => store.helper.disableSaveButton),
    }
  },
}
</script>
