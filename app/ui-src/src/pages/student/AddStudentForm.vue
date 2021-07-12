<template>
  <q-dialog v-model="$store.state.student.showAddForm" 
    :maximized="maximizedDialog()"
    @before-show="formOpen">
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ getLang.siswa_add_title }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">
          <q-input outlined :label="getLang.siswa_nis" minlength="9" maxlength="10" dense v-model="formData.student_nis" />
          <error :label="error.student_nis" />
          
          <q-input outlined :label="getLang.siswa_nama" dense v-model="formData.student_name" />
          <error :label="error.student_name" />

          <search-parents />

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
import { ref, computed, inject } from 'vue'
import { maximizedDialog, cardDialog } from '../../composables/screen'
import { mapState, useStore } from 'vuex'
import SearchParents from './SearchParents.vue'

export default {
  name: 'AddStudentForm',
  components: { SearchParents },
  computed: {
    ...mapState('student', {
      error: state => state.error,
      disableSaveButton: state => state.helper.disableSaveButton
    }),
  },
  setup() {
    const store = useStore()
    const getLang = computed(() => inject('textLang')).value
    const selectedParent = computed(() => store.state.student.selectedParent)

    let formValue = {
      student_nis: '',
      student_name: '',
      parent_id: ''
    }

    let formData = ref(formValue)

    const formOpen = () => {
      const saveStatus = computed(() => store.state.student.saveStatus)
      if(saveStatus.value === 200) {
        formValue = {
          student_nis: '',
          student_name: '',
          parent_id: ''
        }

        store.state.student.saveStatus = 500
        formData.value = formValue
      }
    }
    
    const save = () => {
      formData.value.parent_id = selectedParent.value.id
      store.dispatch('student/save', {
        data: formData.value,
        lang: getLang.value,
        edit: false,
        id: null
      })
    }

    return {
      formData,
      save,
      maximizedDialog, cardDialog,
      getLang,
      formOpen
    }
  }
}
</script>
