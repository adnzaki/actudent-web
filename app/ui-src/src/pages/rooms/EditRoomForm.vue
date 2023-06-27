<template>
  <q-dialog
    no-backdrop-dismiss
    v-model="store.showEditForm"
    :maximized="maximizedDialog()"
  >
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ $t('ruang_edit_title') }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">
          <q-input
            outlined
            :label="$t('ruang_kode')"
            dense
            v-model="store.detail.room_code"
          />
          <ac-error :label="error.room_code" />

          <q-input
            outlined
            :label="$t('ruang_nama')"
            dense
            v-model="store.detail.room_name"
          />
          <ac-error :label="error.room_name" />
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
import { computed } from 'vue'
import { maximizedDialog, cardDialog } from '../../composables/screen'
import { useRoomStore } from 'src/stores/room'

export default {
  name: 'EditRoomForm',
  setup() {
    const store = useRoomStore()

    const save = () => {
      store.save({
        data: store.detail,
        edit: true,
        id: store.detail.room_id,
      })
    }

    return {
      save,
      store,
      cardDialog,
      maximizedDialog,
      error: computed(() => store.error),
      disableSaveButton: computed(() => store.helper.disableSaveButton),
    }
  },
}
</script>
