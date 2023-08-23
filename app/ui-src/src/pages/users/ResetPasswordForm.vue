<template>
  <q-dialog
    no-backdrop-dismiss
    v-model="store.showForm"
    @before-show="formOpen"
    :maximized="maximizedDialog()"
  >
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ $t('user_update_title') }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">
          <q-input
            outlined
            disable
            :label="$t('user_label_nama')"
            class="q-mb-lg"
            dense
            v-model="store.detail.name"
          />

          <q-input
            outlined
            :label="$t('user_pass')"
            dense
            v-model="formData.user_password"
            type="password"
          />
          <ac-error :label="error.user_password" />

          <q-input
            outlined
            :label="$t('user_pass_confirm')"
            dense
            v-model="formData.user_password_confirm"
            type="password"
          />
          <ac-error :label="error.user_password_confirm" />
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
import { useUserStore } from 'src/stores/user'
import { maximizedDialog, cardDialog } from '../../composables/screen'

export default {
  setup() {
    const store = useUserStore()

    const formData = ref({
      user_password: '',
      user_password_confirm: '',
    })

    const save = () => {
      store.save({
        data: formData.value,
        id: store.detail.id,
      })
    }

    const formOpen = () => {
      const saveStatus = computed(() => store.saveStatus)
      if (saveStatus.value === 200) {
        formData.value = {
          user_password: '',
          user_password_confirm: '',
        }

        store.saveStatus = 500
      }
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
