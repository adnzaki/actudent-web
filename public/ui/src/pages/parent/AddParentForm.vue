<template>
  <q-dialog v-model="$store.state.parent.showAddForm">
    <q-card class="q-pa-sm" style="width: 700px;">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ lang.ortu_form_add_title }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section style="max-height: 60vh" class="scroll">
        <q-form>
          <ac-input 
            :label="lang.ortu_kk" 
            :input="formData.parent_family_card" 
            :error="error.parent_family_card">
          </ac-input>
          <ac-input 
            :label="lang.ortu_label_ayah" 
            :input="formData.parent_father_name" 
            :error="error.parent_father_name">
            <q-radio v-model="userName" val="1">
              <q-tooltip anchor="center left" self="center right" :offset="[10, 10]">
                {{ lang.ortu_set_acc_name }}
              </q-tooltip>
            </q-radio>
          </ac-input>
          <ac-input 
            :label="lang.ortu_label_ibu" 
            :input="formData.parent_mother_name"
            :error="error.parent_mother_name">
            <q-radio v-model="userName" val="2">
              <q-tooltip anchor="center left" self="center right" :offset="[10, 10]">
                {{ lang.ortu_set_acc_name }}
              </q-tooltip>
            </q-radio>
          </ac-input>
          <ac-input 
            :label="lang.ortu_label_telp" 
            :input="formData.parent_phone_number"
            :error="error.parent_phone_number">
          </ac-input>
          <ac-input 
            :label="lang.user_email" 
            :input="formData.user_email"
            :error="error.user_email"
            :suffix="`@${school.school_domain}`">
          </ac-input>
          <ac-input 
            type="password"
            :label="lang.user_pass" 
            :input="formData.user_password"
            :error="error.user_password">
          </ac-input>
          <ac-input 
            type="password"
            :label="lang.user_pass_confirm" 
            :input="formData.user_password_confirm"
            :error="error.user_password_confirm">
          </ac-input>
        </q-form>
      </q-card-section>
      <q-separator />
      <q-card-actions align="right">
        <q-btn flat :label="lang.tutup" color="negative" v-close-popup />
        <q-btn :label="lang.simpan" color="primary" padding="8px 20px" />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { ref, onMounted } from 'vue'
import { school, getSchool } from '../../composables/common'
import { mapState } from 'vuex'
import AcInput from 'components/AcInput'

export default {
  name: 'AddParentForm',
  props: ['lang'],
  components: {
    AcInput
  },
  computed: {
    ...mapState('parent', {
      error: state => state.error
    })
  },
  setup() {
    const formData = {
      parent_family_card: '',
      parent_father_name: '',
      parent_mother_name: '',
      parent_phone_number: '',
      user_email: '',
      user_password: '',
      user_password_confirm: '',
    }

    onMounted(getSchool)

    return {
      formData: ref(formData),
      userName: ref('1'),
      school
    }
  }
}
</script>
