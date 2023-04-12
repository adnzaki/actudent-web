<template>
  <q-dialog no-backdrop-dismiss v-model="store.lesson.showAddForm" 
    @before-show="formOpen" :maximized="maximizedDialog()">
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ $t('jadwal_add_mapel_title') }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">   
          <dropdown-search 
            :selected="setLesson"
            :label="$t('jadwal_input_cari_mapel')"
            :list="store.lesson.options"
            :options-value="{ label: 'text', value: 'id' }"
            load-on-route
          />       
          <error :label="error.lesson_id" />

          <dropdown-search 
            :selected="setTeacher"
            :label="$t('jadwal_label_pilih_guru')"
            :list="classStore.teachers"
            :options-value="{ label: 'staff_name', value: 'staff_id' }"
            load-on-route
          />    
          <error :label="error.teacher_id" />
        </q-form>
      </q-card-section>
      <q-separator />
      <q-card-actions align="right">
        <q-btn flat v-if="!$q.screen.lt.sm" :label="$t('tutup')" color="negative" v-close-popup />
        <q-btn class="mobile-form-btn" :label="$t('simpan')" :disable="disableSaveButton" @click="save" color="primary" padding="8px 20px" />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { ref, computed } from 'vue'
import { useRoute } from 'vue-router'
import { useScheduleStore } from 'src/stores/schedule'
import { maximizedDialog, cardDialog } from '../../composables/screen'
import { useClassStore } from 'src/stores/class'

export default {
  name: 'LessonAddForm',
  setup() {
    const store = useScheduleStore()
    const classStore = useClassStore()
    const route = useRoute()

    let formValue = {
      lesson_id: '',
      teacher_id: ''
    }
    
    const setLesson = model => formValue.lesson_id = model.value
    const setTeacher = model => formValue.teacher_id = model.value

    const formData = ref(formValue)

    const formOpen = () => {
      formData.value.teacher_id = classStore.teacherId
      formData.value.lesson_id = store.lesson.lessonId

      const saveStatus = computed(() => store.lesson.saveStatus)
      if(saveStatus.value === 200) {
        formValue = {
          lesson_id: '',
          teacher_id: ''
        }

        store.lesson.saveStatus = 500
        formData.value = formValue
      }
    }
    
    const save = () => {
      store.save({
        data: formData.value,
        edit: false,
        id: null
      })
    }

    return { 
      save,
      store,
      formData,
      formOpen,
      setLesson,
      classStore,
      setTeacher,
      maximizedDialog, cardDialog,
      error: computed(() => store.error),
      disableSaveButton: computed(() => store.helper.disableSaveButton),
    }
  }
}
</script>
