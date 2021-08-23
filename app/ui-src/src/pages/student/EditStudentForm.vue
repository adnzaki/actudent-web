<template>
  <q-dialog v-model="$store.state.student.showEditForm" 
    :maximized="maximizedDialog()"
    @hide="formClose">
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ $t('siswa_add_title') }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">
          <q-input outlined :label="$t('siswa_nis')" minlength="9" maxlength="10" dense 
            v-model="$store.state.student.detail.student_nis" />
          <error :label="error.student_nis" />
          
          <q-input outlined :label="$t('siswa_nama')" dense 
            v-model="$store.state.student.detail.student_name" />
          <error :label="error.student_name" />

          <search-parents />

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
import { computed, inject } from 'vue'
import { maximizedDialog, cardDialog } from '../../composables/screen'
import { mapState, useStore } from 'vuex'
import SearchParents from './SearchParents.vue'

export default {
  name: 'EditStudentForm',
  components: { SearchParents },
  computed: {
    ...mapState('student', {
      error: state => state.error,
      disableSaveButton: state => state.helper.disableSaveButton
    }),
  },
  setup() {
    const store = useStore()
    const selectedParent = computed(() => store.state.student.selectedParent)
  
    const save = () => {
      store.state.student.detail.parent_id = selectedParent.value.id
      store.dispatch('student/save', {
        data: store.state.student.detail,
        edit: true,
        id: store.state.student.detail.student_id
      })
    }

    const formClose = () => {
      store.state.student.selectedParent = {
        id: '', father: '', mother: ''
      }
    }

    return {
      save,
      maximizedDialog, cardDialog,
      formClose
    }
  }
}
</script>
