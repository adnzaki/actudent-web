<template>
  <q-dialog v-model="$store.state[vuexModule]['deleteConfirm']" @hide="closeDeleteConfirm">
    <q-card>
      <q-card-section class="row items-center">
        <q-avatar icon="notification_important" class="mobile-hide" color="negative" text-color="white" />
        <span class="q-ml-sm">{{ $t('sure_to_delete') }}</span>
      </q-card-section>

      <q-card-actions align="right">
        <q-btn flat :label="$t('batal')" color="primary" @click="closeDeleteConfirm" />
        <q-btn flat :label="$t('hapus')" color="primary" 
          :disable="disableSaveButton"
          @click="removeData" />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { useStore } from 'vuex'

export default {
  name: 'DeleteConfirm',
  props: ['vuexModule', 'action'],
  setup(props) {
    const store = useStore()

    return {
      disableSaveButton: () => {
        store.state[props.vuexModule]['disableSaveButton']
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
