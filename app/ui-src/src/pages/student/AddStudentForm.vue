<template>
  <q-dialog no-backdrop-dismiss v-model="store.showAddForm" 
    @before-show="formOpen" :maximized="maximizedDialog()">
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ $t('siswa_add_title') }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">
          <q-input outlined :label="$t('siswa_nis')" minlength="9" maxlength="10" dense v-model="formData.student_nis" />
          <error :label="error.student_nis" />
          
          <q-input outlined :label="$t('siswa_nama')" dense v-model="formData.student_name" />
          <error :label="error.student_name" />

          <search-parents />

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
import SearchParents from './SearchParents.vue'
import { useStudentStore } from 'src/stores/student'
import { maximizedDialog, cardDialog } from '../../composables/screen'

export default {
  components: { SearchParents },
  setup() {
    const store = useStudentStore()
    const selectedParent = computed(() => store.selectedParent)

    let formValue = {
      student_nis: '',
      student_name: '',
      parent_id: ''
    }

    let formData = ref(formValue)

    const formOpen = () => {
      const saveStatus = computed(() => store.saveStatus)
      if(saveStatus.value === 200) {
        formValue = {
          student_nis: '',
          student_name: '',
          parent_id: ''
        }

        store.saveStatus = 500
        formData.value = formValue
      }
    }
    
    const save = () => {
      formData.value.parent_id = selectedParent.value.id
      store.save({
        data: formData.value,
        edit: false,
        id: null
      })
    }

    return {
      save,
      formData,
      formOpen,
      error: store.error,
      maximizedDialog, cardDialog,
      disableSaveButton: store.helper.disableSaveButton,
    }
  }
}
</script>
