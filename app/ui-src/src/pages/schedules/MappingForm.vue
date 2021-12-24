<template>
  <q-dialog v-model="$store.state.schedule.schedule.showForm" 
    @before-show="formOpen" @hide="formClose">
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ $t('jadwal_add_title') }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <!-- Schedule list -->
        <div v-if="schedule.showLessonList">
          <q-input standout dense disable
            v-for="(item, index) in schedule.lessonsInput" :key="index"
            v-model="item.text"
            class="q-mb-xs">
            <template v-slot:after>
              <q-btn round dense flat icon="delete" color="negative" @click="removeLesson(item.id)" />
            </template>
          </q-input>  

          <div class="column items-center q-mt-md">
            <p v-if="schedule.lessonsInput.length === 0"> {{ $t('jadwal_kosong') }} </p>
            <q-btn round color="primary" icon="add" @click="showFormInput">
              <q-tooltip anchor="top middle" self="bottom middle" :offset="[10, 10]">
                {{ $t('tambah') }}
              </q-tooltip>
            </q-btn>
          </div>
        </div>

        <!-- Add schedule's item -->
        <mapping-form-input />

      </q-card-section>
      
      <q-separator />

      <q-card-actions align="right">
        <q-btn flat :label="$t('tutup')" color="negative" v-close-popup />
        <q-btn :label="$t('simpan')" 
          :disable="disableSaveButton" 
          @click="$store.dispatch('schedule/saveSchedules')" 
          color="primary" padding="8px 20px" 
        />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { ref, computed } from 'vue'
import { maximizedDialog, cardDialog } from '../../composables/screen'
import { mapState, useStore } from 'vuex'
import MappingFormInput from './MappingFormInput.vue'

export default {
  name: 'MappingForm',
  components: { MappingFormInput },
  computed: {
    ...mapState('schedule', {
      error: state => state.error,
      disableSaveButton: state => state.helper.disableSaveButton,
      schedule: state => state.schedule
    }),
  },
  setup() {
    const store = useStore()

    const formOpen = () => {
      const saveStatus = computed(() => store.state.schedule.schedule.saveStatus)
      if(saveStatus.value === 200) {
        formValue = {
          lesson_id: '',
          teacher_id: ''
        }

        store.state.schedule.schedule.saveStatus = 500
        formData.value = formValue
      }
    }

    const showFormInput = () => {
      store.state.schedule.schedule.showLessonList = false
      store.state.schedule.schedule.showLessonInput = true
      store.state.schedule.helper.disableSaveButton = true
      store.state.schedule.schedule.lessonOptions = store.state.schedule.schedule.normalList
    }

    const removeLesson = id => store.commit('schedule/removeLesson', id)

    const formClose = () => {
      store.state.schedule.schedule.lessonOptions = store.state.schedule.schedule['normalList']
      store.state.schedule.schedule.showLessonInput = false
      store.state.schedule.schedule.showBreakInput = false
      store.state.schedule.schedule.showLessonList = true
      store.state.schedule.helper.disableSaveButton = false
    }

    return {
      showFormInput,
      maximizedDialog, cardDialog,
      formOpen,
      removeLesson,
      formClose
    }
  }
}
</script>
