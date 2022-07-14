<template>
  <q-dialog v-model="$store.state.employee.showEditForm" 
    @before-show="formOpen" :maximized="maximizedDialog()"
    @hide="$store.state.employee.helper.filename = ''">
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ $t('staff_edit_title') }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">
          <q-input outlined :label="$t('staff_input_id')" minlength="10" maxlength="10" dense 
            v-model="$store.state.employee.detail.staff_nik" />
          <error :label="error.staff_nik" />
          
          <q-input outlined :label="$t('staff_label_nama')" dense 
            v-model="$store.state.employee.detail.staff_name" />
          <error :label="error.staff_name" />

          <q-input outlined :label="$t('staff_label_telp')" minlength="11" maxlength="13" dense 
            v-model="$store.state.employee.detail.staff_phone" />
          <error :label="error.staff_phone" />

          <div>
            {{ $t('staff_label_jenis') }}
          </div>
          <div class="row q-mb-md">
            <div class="col-6"><q-radio v-model="$store.state.employee.detail.staff_type" val="teacher" :label="$t('staff_input_guru')" /></div>
            <div class="col-6"><q-radio v-model="$store.state.employee.detail.staff_type" val="staff" label="Staff" /></div>
          </div>

          <q-input outlined :label="$t('staff_label_jabatan')" dense 
            v-model="$store.state.employee.detail.staff_title" />
          <error :label="error.staff_title" />

          <q-file
            color="grey-3" outlined dense 
            v-model="formData.staff_photo" 
            :label="$t('staff_label_photo')"
            @update:model-value="encodeImage"
            accept="image/jpeg, image/png">
            <template v-slot:prepend>
              <q-icon name="cloud_upload" />
            </template>
          </q-file>

          <employee-photo />
          
          <error :label="error.staff_photo" />
          <error :label="error.featured_image" />
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
import { ref, onMounted } from 'vue'
import { school, getSchool } from '../../composables/common'
import { maximizedDialog, cardDialog } from '../../composables/screen'
import { mapState, useStore } from 'vuex'

export default {
  name: 'EditEmployeeForm',
  computed: {
    ...mapState('employee', {
      error: state => state.error,
      disableSaveButton: state => state.helper.disableSaveButton,
    }),
  },
  setup() {
    const store = useStore()

    const formData = ref({
      staff_type: 'teacher',
      staff_photo: null,
    })

    const formOpen = () => {
      formData.value.staff_photo = null
    }

    onMounted(getSchool)
    
    const save = () => {
      store.dispatch('employee/save', {
        data: store.state.employee.detail,
        edit: true,
        id: store.state.employee.detail.user_id
      })
    }

    const encodeImage = val => {
      store.commit('employee/uploadImage', val)
    }

    return {
      formData,
      school,
      save,
      maximizedDialog, cardDialog,
      encodeImage,
      formOpen
    }
  }
}
</script>
