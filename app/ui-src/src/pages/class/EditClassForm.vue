<template>
  <q-dialog no-backdrop-dismiss v-model="$store.state.grade.showEditForm"
   :maximized="maximizedDialog()">
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ $t('kelas_edit_title') }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">          
          <q-input outlined :label="$t('kelas_label_nama')" dense v-model="$store.state.grade.detail.grade_name" />
          <error :label="error.grade_name" />

          <dropdown-search 
            vuex-module="grade"
            :selected="setTeacher"
            :default="{
              label: $store.state.grade.detail.staff_name,
              value: $store.state.grade.detail.teacher_id
            }"
            :list="$store.state.grade.teachers"
            :options-value="{ label: 'staff_name', value: 'staff_id' }"
            load-on-route
            :label="$t('kelas_wali')"
          />    

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
import { ref } from 'vue'
import { maximizedDialog, cardDialog } from '../../composables/screen'
import { mapState, useStore } from 'vuex'
import SearchTeacher from './SearchTeacher.vue'

export default {
  name: 'EditClassForm',
  components: { SearchTeacher },
  computed: {
    ...mapState('grade', {
      error: state => state.error,
      disableSaveButton: state => state.helper.disableSaveButton
    }),
  },
  setup() {
    const store = useStore()
    
    const setTeacher = model => store.state.grade.detail.teacher_id = model.value
    
    const save = () => {
      store.dispatch('grade/save', {
        data: store.state.grade.detail,
        edit: true,
        id: store.state.grade.detail.grade_id
      })
    }


    return {
      save,
      maximizedDialog, cardDialog,
      setTeacher
    }
  }
}
</script>
