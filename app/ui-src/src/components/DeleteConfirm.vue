<template>
  <q-dialog v-model="$store.state[vuexModule]['deleteConfirm']" @hide="closeDeleteConfirm">
    <q-card>
      <q-card-section class="row items-center">
        <q-avatar icon="notification_important" class="mobile-hide" color="negative" text-color="white" />
        <span class="q-ml-sm">{{ getLang.sure_to_delete }}</span>
      </q-card-section>

      <q-card-actions align="right">
        <q-btn flat :label="getLang.batal" color="primary" @click="closeDeleteConfirm" />
        <q-btn flat :label="getLang.hapus" color="primary" 
          :disable="disableSaveButton"
          @click="deleteParent" />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { inject, computed } from 'vue'
import { useStore } from 'vuex'

export default {
  name: 'DeleteConfirm',
  props: ['vuexModule'],
  setup(props) {
    const store = useStore()

    const getLang = computed(() => inject('textLang')).value

    return {
      disableSaveButton: () => {
        store.state[props.vuexModule]['disableSaveButton']
      },
      closeDeleteConfirm: () => {
        store.commit(`${props.vuexModule}/closeDeleteConfirm`)
      },
      deleteParent: () => {
        store.dispatch(`${props.vuexModule}/deleteParent`, getLang.value)
      },
      getLang
    }
  }
}
</script>
