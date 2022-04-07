<template>
  <q-dialog v-model="$store.state.grade.showAddForm" 
    @before-show="formOpen">
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ $t('kelas_add_title') }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">          
          <q-input outlined :label="$t('kelas_label_nama')" dense v-model="formData.grade_name" />
          <error :label="error.grade_name" />

          <dropdown-search 
            vuex-module="grade"
            :selected="setTeacher"
            :label="$t('kelas_wali')"
            :list="$store.state.grade.teachers"
            :options-value="{ label: 'staff_name', value: 'staff_id' }"
            load-on-route
          />    

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
import SearchTeacher from './SearchTeacher.vue'

export default {
  name: 'AddClassForm',
  components: { SearchTeacher },
  computed: {
    ...mapState('grade', {
      error: state => state.error,
      disableSaveButton: state => state.helper.disableSaveButton
    }),
  },
  setup() {
    const store = useStore()

    let formValue = {
      grade_name: '',
      teacher_id: ''
    }

    const setTeacher = model => formValue.teacher_id = model.value

    const formData = ref(formValue)

    const formOpen = () => {
      // set default value
      formData.value.teacher_id = store.state.grade.teacherId

      const saveStatus = computed(() => store.state.grade.saveStatus)
      if(saveStatus.value === 200) {
        formValue = {
          grade_name: '',
          teacher_id: ''
        }

        store.state.grade.saveStatus = 500
        formData.value = formValue
      }
    }
    
    const save = () => {
      store.dispatch('grade/save', {
        data: formData.value,
        edit: false,
        id: null
      })
    }

    return {
      formData,
      save,
      maximizedDialog, cardDialog,
      formOpen,
      setTeacher
    }
  }
}
</script>
