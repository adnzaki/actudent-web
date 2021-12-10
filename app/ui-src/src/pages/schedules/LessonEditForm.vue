<template>
  <q-dialog v-model="$store.state.schedule.lesson.showEditForm">
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ $t('jadwal_edit_mapel_title') }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">   
          <dropdown-search 
            vuex-module="schedule"
            :selected="setLesson"
            :default="{
              label: $store.state.schedule.lesson.detail.lesson_name,
              value: $store.state.schedule.lesson.detail.lesson_id
            }"
            :label="$t('jadwal_input_cari_mapel')"
            :list="$store.state.schedule.lesson.options"
            :options-value="{ label: 'text', value: 'id' }"
            load-on-route
          />       
          <error :label="error.lesson_id" />

          <dropdown-search 
            vuex-module="schedule"
            :selected="setTeacher"
            :default="{
              label: $store.state.schedule.lesson.detail.teacher,
              value: $store.state.schedule.lesson.detail.teacher_id
            }"
            :label="$t('jadwal_label_pilih_guru')"
            :list="$store.state.grade.teachers"
            :options-value="{ label: 'staff_name', value: 'staff_id' }"
            load-on-route
          />    
          <error :label="error.teacher_id" />
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
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import { maximizedDialog, cardDialog } from '../../composables/screen'
import { mapState, useStore } from 'vuex'

export default {
  name: 'LessonEditForm',
  computed: {
    ...mapState('schedule', {
      error: state => state.error,
      disableSaveButton: state => state.helper.disableSaveButton
    }),
  },
  setup() {
    const store = useStore()
    
    const setLesson = model => store.state.schedule.lesson.detail.lesson_id = model.value
    const setTeacher = model => store.state.schedule.lesson.detail.teacher_id = model.value
    
    const save = () => {
      store.dispatch('schedule/saveLesson', {
        data: store.state.schedule.lesson.detail,
        edit: true,
        id: store.state.schedule.lesson.detail.lessons_grade_id
      })
    }

    return {
      save,
      maximizedDialog, cardDialog,
      setLesson,
      setTeacher
    }
  }
}
</script>
