<template>
  <q-dialog 
    v-model="$store.state.presence.showPermissionForm" @hide="formClose">
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ $t('absensi_form_izin_title') }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">

        <q-form class="q-gutter-xs" @submit.prevent="save">          
          <q-input outlined :label="$t('absensi_izin_label')" dense 
            v-model="$store.state.presence.permissionNote" autofocus />
        </q-form>
        
      </q-card-section>
      <q-separator />
      <q-card-actions align="right">
        <q-btn flat :label="$t('tutup')" color="negative" v-close-popup />
        <q-btn :label="$t('simpan')" :disable="$store.state.presence.disableSaveButton" @click="save" color="primary" padding="8px 20px" />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { maximizedDialog, cardDialog } from '../../composables/screen'
import { useStore } from 'vuex'

export default {
  name: 'PermissionForm',
  setup() {
    const store = useStore()

    const save = () => {
      store.dispatch('presence/submitPermission')
    }

    const formClose = () => store.state.presence.studentPresence = []

    return {
      save,
      maximizedDialog, cardDialog,
      formClose
    }
  }
}
</script>
