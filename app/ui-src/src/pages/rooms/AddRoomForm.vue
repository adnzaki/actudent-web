<template>
  <q-dialog v-model="$store.state.rooms.showAddForm" 
    @before-show="formOpen">
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ $t('ruang_form_add_title') }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">          
          <q-input outlined :label="$t('ruang_kode')" dense v-model="formData.room_code" />
          <error :label="error.room_code" />

          <q-input outlined :label="$t('ruang_nama')" dense v-model="formData.room_name" />
          <error :label="error.room_name" />
        </q-form>
      </q-card-section>
      <q-separator />
      <q-card-actions align="right">
        <q-btn flat :label="$t('tutup')" color="negative" v-close-popup />
        <q-btn :label="$t('simpan')" :disable="disableSaveButton" @click="save" color="primary" padding="8px 20px" />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { ref, computed } from 'vue'
import { maximizedDialog, cardDialog } from '../../composables/screen'
import { mapState, useStore } from 'vuex'

export default {
  name: 'AddRoomForm',
  computed: {
    ...mapState('rooms', {
      error: state => state.error,
      disableSaveButton: state => state.helper.disableSaveButton
    }),
  },
  setup() {
    const store = useStore()

    let formValue = {
      room_code: '',
      room_name: ''
    }

    const formData = ref(formValue)

    const formOpen = () => {
      const saveStatus = computed(() => store.state.rooms.saveStatus)
      if(saveStatus.value === 200) {
        formValue = {
          room_code: '',
          room_name: ''
        }

        store.state.rooms.saveStatus = 500
        formData.value = formValue
      }
    }
    
    const save = () => {
      store.dispatch('rooms/save', {
        data: formData.value,
        edit: false,
        id: null
      })
    }

    return {
      formData,
      save,
      maximizedDialog, cardDialog,
      formOpen
    }
  }
}
</script>
