<template>
  <q-dialog v-model="$store.state.schedule.schedule.showForm" 
    @before-show="formOpen">
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
            <q-btn round color="primary" icon="add" @click="showAddNormalSchedule">
              <q-tooltip anchor="top middle" self="bottom middle" :offset="[10, 10]">
                {{ $t('tambah') }}
              </q-tooltip>
            </q-btn>
          </div>
        </div>
        <!-- Add normal schedule -->
        <mapping-add-normal />

        <!-- Add a break -->

        <!-- Add from inactive schedule -->
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
import MappingAddNormal from './MappingAddNormal.vue'

export default {
  name: 'MappingForm',
  components: { MappingAddNormal },
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

    const showAddNormalSchedule = () => {
      store.state.schedule.schedule.showLessonList = false
      store.state.schedule.schedule.showLessonInput = true
    }

    const removeLesson = id => store.commit('schedule/removeLesson', id)

    return {
      showAddNormalSchedule,
      maximizedDialog, cardDialog,
      formOpen,
      removeLesson
    }
  }
}
</script>
