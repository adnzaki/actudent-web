<template>
  <q-dialog
    no-backdrop-dismiss
    v-model="store.showPermissionForm"
    @hide="formClose"
    :maximized="maximizedDialog()"
  >
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">
          {{ $t('absensi_form_izin_title') }}
        </div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs" @submit.prevent="save">
          <q-input
            outlined
            :label="$t('absensi_izin_label')"
            dense
            v-model="store.permissionNote"
            autofocus
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
import { usePresenceStore } from 'src/stores/presence'
import { maximizedDialog, cardDialog } from '../../composables/screen'

export default {
  name: 'PermissionForm',
  setup() {
    const store = usePresenceStore()

    const save = () => {
      store.submitPermission()
    }

    const formClose = () => (store.studentPresence = [])

    return {
      save,
      store,
      formClose,
      maximizedDialog,
      cardDialog,
    }
  },
}
</script>
