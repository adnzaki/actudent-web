<template>
  <q-dialog v-model="$store.state.parent.deleteConfirm" @hide="closeDeleteConfirm">
    <q-card>
      <q-card-section class="row items-center">
        <q-avatar icon="notification_important" color="negative" text-color="white" />
        <span class="q-ml-sm">{{ lang.sure_to_delete }}</span>
      </q-card-section>

      <q-card-actions align="right">
        <q-btn flat :label="lang.batal" color="primary" @click="closeDeleteConfirm" />
        <q-btn flat :label="lang.hapus" color="primary" 
          :disable="disableSaveButton"
          @click="deleteParent(lang)" />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { mapMutations, mapActions, mapState } from 'vuex'

export default {
  name: 'DeleteConfirm',
  props: ['lang'],
  methods: {
    ...mapMutations('parent', [
      'closeDeleteConfirm'
    ]),
    ...mapActions('parent', [
      'deleteParent'
    ])
  },
  computed: {
    ...mapState('parent', {
      deleteConfirm: state => state.deleteConfirm,
      disableSaveButton: state => state.helper.disableSaveButton
    })
  }
}
</script>
