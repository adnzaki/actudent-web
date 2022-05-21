<template>
  <q-dialog v-model="$store.state[vuexModule]['deleteConfirm']" @hide="closeDeleteConfirm">
    <q-card>
      <q-card-section class="row items-center">
        <q-avatar icon="notification_important" class="mobile-hide" color="negative" text-color="white" />
        <span class="q-ml-sm">{{ confirmText }}</span>
      </q-card-section>

      <q-card-actions align="right">
        <q-btn flat :label="$t('batal')" color="primary" @click="closeDeleteConfirm" />
        <q-btn flat :label="$t('hapus')" color="primary" 
          :disable="disableSaveButton()"
          @click="removeData" />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { useStore } from 'vuex'
import { computed } from 'vue'
import { t } from 'src/composables/common'

export default {
  name: 'DeleteConfirm',
  props: ['vuexModule', 'action', 'customText'],
  setup(props) {
    const store = useStore()

    return {
      confirmText: computed(() => {
        return props.customText !== undefined 
                ? props.customText 
                : t('sure_to_delete')
      }),
      disableSaveButton: () => {
        return store.state[props.vuexModule]['disableSaveButton']
      },
      closeDeleteConfirm: () => {
        store.commit(`${props.vuexModule}/closeDeleteConfirm`)
      },
      removeData: () => {
        store.dispatch(`${props.vuexModule}/${props.action}`)
      },
    }
  }
}
</script>
