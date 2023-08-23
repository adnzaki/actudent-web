<template>
  <q-dialog
    no-backdrop-dismiss
    v-model="store.showAddForm"
    @before-show="formOpen"
    :maximized="maximizedDialog()"
  >
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">
          {{ $t('mapel_form_add_title') }}
        </div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">
          <q-input
            outlined
            :label="$t('mapel_kode')"
            dense
            v-model="formData.lesson_code"
          />
          <ac-error :label="error.lesson_code" />

          <q-input
            outlined
            :label="$t('mapel_nama')"
            dense
            v-model="formData.lesson_name"
          />
          <ac-error :label="error.lesson_name" />
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
import { ref, computed } from 'vue'
import { maximizedDialog, cardDialog } from '../../composables/screen'
import { useLessonStore } from 'src/stores/lesson'

export default {
  name: 'AddLessonForm',
  setup() {
    const store = useLessonStore()

    let formValue = {
      lesson_code: '',
      lesson_name: '',
    }

    const formData = ref(formValue)

    const formOpen = () => {
      const saveStatus = computed(() => store.saveStatus)
      if (saveStatus.value === 200) {
        formValue = {
          lesson_code: '',
          lesson_name: '',
        }

        store.saveStatus = 500
        formData.value = formValue
      }
    }

    const save = () => {
      store.save({
        data: formData.value,
        edit: false,
        id: null,
      })
    }

    return {
      save,
      store,
      formData,
      formOpen,
      maximizedDialog,
      cardDialog,
      error: computed(() => store.error),
      disableSaveButton: computed(() => store.helper.disableSaveButton),
    }
  },
}
</script>
