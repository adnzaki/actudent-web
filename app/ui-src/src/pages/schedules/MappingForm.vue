<template>
  <q-dialog
    no-backdrop-dismiss
    v-model="store.schedule.showForm"
    @before-show="formOpen"
    @hide="formClose"
    :maximized="maximizedDialog()"
  >
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ $t('jadwal_add_title') }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <!-- Schedule list -->
        <div v-if="schedule.showLessonList">
          <q-input
            standout
            dense
            disable
            v-for="(item, index) in schedule.lessonsInput"
            :key="index"
            v-model="item.text"
            class="q-mb-xs"
          >
            <template v-slot:after>
              <q-btn
                round
                dense
                flat
                icon="delete"
                color="negative"
                @click="removeLesson(item.id)"
              />
            </template>
          </q-input>

          <div class="column items-center q-mt-md">
            <p v-if="schedule.lessonsInput.length === 0">
              {{ $t('jadwal_kosong') }}
            </p>
            <q-btn round :class="addButton" icon="add" @click="showFormInput">
              <q-tooltip
                anchor="top middle"
                self="bottom middle"
                :offset="[10, 10]"
              >
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
        <q-btn
          flat
          v-if="!$q.screen.lt.sm"
          :label="$t('tutup')"
          color="negative"
          v-close-popup
        />
        <q-btn
          :label="$t('simpan')"
          class="mobile-form-btn save-btn"
          unelevated
          :disable="disableSaveButton"
          @click="store.saveSchedules()"
        />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { computed } from 'vue'
import MappingFormInput from './MappingFormInput.vue'
import { useScheduleStore } from 'src/stores/schedule'
import { maximizedDialog, cardDialog } from '../../composables/screen'
import { addButton } from 'src/composables/mode'

export default {
  name: 'MappingForm',
  components: { MappingFormInput },
  setup() {
    const store = useScheduleStore()

    const formOpen = () => {
      const saveStatus = computed(() => store.schedule.saveStatus)
      if (saveStatus.value === 200) {
        formValue = {
          lesson_id: '',
          teacher_id: '',
        }

        store.schedule.saveStatus = 500
        formData.value = formValue
      }
    }

    const showFormInput = () => {
      store.schedule.showLessonList = false
      store.schedule.showLessonInput = true
      store.helper.disableSaveButton = true
      store.schedule.lessonOptions = store.schedule.normalList
    }

    const removeLesson = (id) => store.removeLesson(id)

    const formClose = () => {
      store.schedule.lessonOptions = store.schedule['normalList']
      store.schedule.showLessonInput = false
      store.schedule.showBreakInput = false
      store.schedule.showLessonList = true
      store.helper.disableSaveButton = false
    }

    return {
      store,
      formOpen,
      formClose,
      addButton,
      removeLesson,
      showFormInput,
      maximizedDialog,
      cardDialog,
      error: computed(() => store.error),
      schedule: computed(() => store.schedule),
      disableSaveButton: computed(() => store.helper.disableSaveButton),
    }
  },
}
</script>
