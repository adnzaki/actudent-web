<template>
  <q-dialog
    no-backdrop-dismiss
    :model-value="store.deleteConfirm"
    @hide="closeDeleteConfirm"
  >
    <q-card>
      <q-card-section class="row items-center">
        <div class="row">
          <div class="col-2">
            <q-avatar
              icon="notification_important"
              class="mobile-hide"
              color="negative"
              text-color="white"
            />
          </div>
          <div class="col-10 q-mt-xs">
            <span>{{ confirmText }}</span>
          </div>
        </div>
      </q-card-section>

      <q-card-actions align="right">
        <q-btn
          flat
          :label="$t('batal')"
          color="primary"
          @click="closeDeleteConfirm"
        />
        <q-btn
          flat
          :label="okButton"
          color="primary"
          :disable="disableButton(store)"
          @click="$emit('action')"
        />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { computed } from 'vue'
import { t } from 'src/composables/common'

export default {
  props: ['store', 'action', 'customText', 'okButtonText'],
  emits: ['action'],
  setup(props) {
    return {
      disableButton(store) {
        return store.disableSaveButton === undefined
          ? store.helper.disableSaveButton
          : store.disableSaveButton
      },
      confirmText: computed(() => {
        return props.customText !== undefined
          ? props.customText
          : t('sure_to_delete')
      }),
      okButton: computed(() => {
        return props.okButtonText !== undefined
          ? props.okButtonText
          : t('hapus')
      }),
      closeDeleteConfirm: () => props.store.closeDeleteConfirm(),
    }
  },
}
</script>
