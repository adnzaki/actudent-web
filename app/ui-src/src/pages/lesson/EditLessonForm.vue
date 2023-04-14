<template>
  <q-dialog
    no-backdrop-dismiss
    v-model="store.showEditForm"
    :maximized="maximizedDialog()"
  >
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ $t("mapel_edit_title") }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">
          <q-input
            outlined
            :label="$t('mapel_kode')"
            dense
            v-model="store.detail.lesson_code"
          />
          <ac-error :label="error.lesson_code" />

          <q-input
            outlined
            :label="$t('mapel_nama')"
            dense
            v-model="store.detail.lesson_name"
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
        />
        <q-btn
          :label="$t('simpan')"
          class="mobile-form-btn"
          :disable="disableSaveButton"
          @click="save"
          color="primary"
          padding="8px 20px"
        />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { maximizedDialog, cardDialog } from "../../composables/screen";
import { useLessonStore } from "src/stores/lesson";

export default {
  name: "EditLessonForm",
  setup() {
    const store = useLessonStore();

    const save = () => {
      store.save({
        data: store.detail,
        edit: true,
        id: store.detail.lesson_id,
      });
    };

    return {
      save,
      store,
      maximizedDialog,
      cardDialog,
      error: computed(() => store.error),
      disableSaveButton: computed(() => store.helper.disableSaveButton),
    };
  },
};
</script>
