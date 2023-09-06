<template>
  <q-dialog
    no-backdrop-dismiss
    v-model="store.showEditForm"
    :maximized="maximizedDialog()"
  >
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ $t('kelas_edit_title') }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">
          <q-input
            outlined
            :label="$t('kelas_label_nama')"
            dense
            v-model="store.detail.grade_name"
          />
          <ac-error :label="error.grade_name" />

          <dropdown-search
            @selected="setTeacher"
            :default="{
              label: store.detail.staff_name,
              value: store.detail.teacher_id,
            }"
            :list="store.teachers"
            :options-value="{ label: 'staff_name', value: 'staff_id' }"
            load-on-route
            :label="$t('kelas_wali')"
          />
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
import { maximizedDialog, cardDialog } from '../../composables/screen'
import { useClassStore } from 'src/stores/class'

export default {
  name: 'EditClassForm',
  setup() {
    const store = useClassStore()

    const setTeacher = (model) => (store.detail.teacher_id = model.value)

    const save = () => {
      store.save({
        data: store.detail,
        edit: true,
        id: store.detail.grade_id,
      })
    }

    return {
      store,
      save,
      maximizedDialog,
      cardDialog,
      setTeacher,
      error: computed(() => store.error),
      disableSaveButton: computed(() => store.helper.disableSaveButton),
    }
  },
}
</script>
