<template>
  <q-dialog no-backdrop-dismiss v-model="$store.state.users.showForm" 
    @before-show="formOpen" :maximized="maximizedDialog()">
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ $t('user_update_title') }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">
          <q-input outlined disable :label="$t('user_label_nama')" class="q-mb-lg" dense v-model="$store.state.users.detail.name" />

          <q-input outlined :label="$t('user_pass')" dense 
            v-model="formData.user_password" type="password" />
          <error :label="error.user_password" />

          <q-input outlined :label="$t('user_pass_confirm')" dense 
            v-model="formData.user_password_confirm" type="password" />
          <error :label="error.user_password_confirm" />
        </q-form>
      </q-card-section>
      <q-separator />
      <q-card-actions align="right">
        <q-btn flat :label="$t('tutup')" v-if="!$q.screen.lt.sm" color="negative" v-close-popup />
        <q-btn :label="$t('simpan')" class="mobile-form-btn" :disable="disableSaveButton" @click="save" color="primary" padding="8px 20px" />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { ref, computed } from 'vue'
import { maximizedDialog, cardDialog } from '../../composables/screen'
import { mapState, useStore } from 'vuex'

export default {
  computed: {
    ...mapState('users', {
      error: state => state.error,
      disableSaveButton: state => state.helper.disableSaveButton,
    }),
  },
  setup() {
    const store = useStore()

    const formData = ref({
      user_password: '',
      user_password_confirm: ''
    })
    
    const save = () => {
      store.dispatch('users/save', {
        data: formData.value,
        id: store.state.users.detail.id
      })
    }

    const formOpen = () => {
      const saveStatus = computed(() => store.state.users.saveStatus)
      if(saveStatus.value === 200) {
        formData.value = {
          user_password: '',
          user_password_confirm: ''
        }

        store.state.users.saveStatus = 500
      }
    }

    return {
      formData,
      save,
      maximizedDialog, cardDialog,
      formOpen,
    }
  }
}
</script>
