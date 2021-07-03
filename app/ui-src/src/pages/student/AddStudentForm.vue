<template>
  <q-dialog v-model="$store.state.student.showAddForm" :maximized="maximizedDialog()">
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ getLang.siswa_add_title }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section :style="cardSection()" class="scroll">
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
import { ref, onMounted, watch, computed, inject } from 'vue'
import { school, getSchool } from '../../composables/common'
import { maximizedDialog, cardDialog, cardSection } from '../../composables/screen'
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

    onMounted(getSchool)
    
    const save = () => {
      formData.value.parent_id = selectedParent.value.id
      // store.dispatch('parent/save', {
      //   data: formData.value,
      //   lang: getLang.value,
      //   edit: false,
      //   id: null
      // })
    }

    let saveStatus = computed(() => store.state.parent.saveStatus)
    watch(saveStatus, () => {
      if(saveStatus.value === 200) {
        formData.value = formValue
      }
    })

    return {
      formData,
      school,
      save,
      maximizedDialog, cardDialog, cardSection,
      getLang
    }
  }
}
</script>
