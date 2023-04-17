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
          {{ $t('ruang_form_add_title') }}
        </div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">
          <q-input
            outlined
            :label="$t('ruang_kode')"
            dense
            v-model="formData.room_code"
          />
          <ac-error :label="error.room_code" />

          <q-input
            outlined
            :label="$t('ruang_nama')"
            dense
            v-model="formData.room_name"
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
import { ref, computed } from 'vue'
import { useRoomStore } from 'src/stores/room'
import { maximizedDialog, cardDialog } from '../../composables/screen'

export default {
  name: 'AddRoomForm',
  setup() {
    const store = useRoomStore()

    let formValue = {
      room_code: '',
      room_name: '',
    }

    const formData = ref(formValue)

    const formOpen = () => {
      const saveStatus = computed(() => store.saveStatus)
      if (saveStatus.value === 200) {
        formValue = {
          room_code: '',
          room_name: '',
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
      cardDialog,
      maximizedDialog,
      error: computed(() => store.error),
      disableSaveButton: computed(() => store.helper.disableSaveButton),
    }
  },
}
</script>
