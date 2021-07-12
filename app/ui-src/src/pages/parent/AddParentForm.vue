<template>
  <q-dialog v-model="$store.state.parent.showAddForm" 
    :maximized="maximizedDialog()"
    @before-show="formOpen">
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ getLang.ortu_form_add_title }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">
          <q-input outlined :label="getLang.ortu_kk" minlength="16" maxlength="16" dense v-model="formData.parent_family_card" />
          <error :label="error.parent_family_card" />
          
          <q-input outlined :label="getLang.ortu_label_ayah" dense v-model="formData.parent_father_name">
            <q-radio v-model="formData.user_name" val="1">
              <q-tooltip anchor="center left" self="center right" :offset="[10, 10]">
                {{ getLang.ortu_set_acc_name }}
              </q-tooltip>
            </q-radio>
          </q-input>
          <error :label="error.parent_father_name" />

          <q-input outlined :label="getLang.ortu_label_ibu" dense v-model="formData.parent_mother_name">
            <q-radio v-model="formData.user_name" val="2">
              <q-tooltip anchor="center left" self="center right" :offset="[10, 10]">
                {{ getLang.ortu_set_acc_name }}
              </q-tooltip>
            </q-radio>
          </q-input>
          <error :label="error.parent_mother_name" />

          <q-input outlined :label="getLang.ortu_label_telp" minlength="11" maxlength="13" dense v-model="formData.parent_phone_number" />
          <error :label="error.parent_phone_number" />

          <q-input outlined :label="getLang.user_email" dense 
            v-model="formData.user_email" :suffix="`@${school.school_domain}`" />
          <error :label="error.user_email" />

          <q-input outlined :label="getLang.user_pass" dense 
            v-model="formData.user_password" type="password" />
          <error :label="error.user_password" />

          <q-input outlined :label="getLang.user_pass_confirm" dense 
            v-model="formData.user_password_confirm" type="password" />
          <error :label="error.user_password_confirm" />
        </q-form>
      </q-card-section>
      <q-separator />
      <q-card-actions align="right">
        <q-btn flat :label="getLang.tutup" color="negative" v-close-popup />
        <q-btn :label="getLang.simpan" :disable="disableSaveButton" @click="save" color="primary" padding="8px 20px" />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { ref, onMounted, watch, computed, inject } from 'vue'
import { school, getSchool } from '../../composables/common'
import { maximizedDialog, cardDialog } from '../../composables/screen'
import { mapState, useStore } from 'vuex'

export default {
  name: 'AddParentForm',
  computed: {
    ...mapState('parent', {
      error: state => state.error,
      disableSaveButton: state => state.helper.disableSaveButton
    }),
  },
  setup() {
    const store = useStore()

    const getLang = computed(() => inject('textLang')).value

    let formData = ref({
      parent_family_card: '',
      parent_father_name: '',
      parent_mother_name: '',
      parent_phone_number: '',
      user_email: '',
      user_password: '',
      user_password_confirm: '',
      user_name: '1'   
    })

    onMounted(getSchool)
    
    const save = () => {
      store.dispatch('parent/save', {
        data: formData.value,
        lang: getLang.value,
        edit: false,
        id: null
      })
    }

    const formOpen = () => {
      const saveStatus = computed(() => store.state.parent.saveStatus)
      if(saveStatus.value === 200) {
        formData.value = {
          parent_family_card: '',
          parent_father_name: '',
          parent_mother_name: '',
          parent_phone_number: '',
          user_email: '',
          user_password: '',
          user_password_confirm: '',
          user_name: '1'
        }

        store.state.parent.saveStatus = 500
      }
    }

    return {
      formData,
      school,
      save,
      maximizedDialog, cardDialog,
      getLang,
      formOpen
    }
  }
}
</script>
