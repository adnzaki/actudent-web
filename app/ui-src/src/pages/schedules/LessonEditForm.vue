<template>
  <q-dialog
    no-backdrop-dismiss
    v-model="store.lesson.showEditForm"
    :maximized="maximizedDialog()"
  >
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">
          {{ $t('jadwal_edit_mapel_title') }}
        </div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">
          <dropdown-search
            @selected="setLesson"
            :default="{
              label: store.lesson.detail.lesson_name,
              value: store.lesson.detail.lesson_id,
            }"
            :label="$t('jadwal_input_cari_mapel')"
            :list="store.lesson.options"
            :options-value="{ label: 'text', value: 'id' }"
            load-on-route
          />
          <ac-error :label="error.lesson_id" />

          <dropdown-search
            @selected="setTeacher"
            :default="{
              label: store.lesson.detail.teacher,
              value: store.lesson.detail.teacher_id,
            }"
            :label="$t('jadwal_label_pilih_guru')"
            :list="classStore.teachers"
            :options-value="{ label: 'staff_name', value: 'staff_id' }"
            load-on-route
          />
          <ac-error :label="error.teacher_id" />
        </q-form>
      </q-card-section>
      <q-separator />
      <q-card-actions align="right">
        <q-btn
          flat
          :label="$t('tutup')"
          v-if="!$q.screen.lt.sm"
          color="negative"
          v-close-popup
          class="close-btn"
        />
        <q-btn
          :label="$t('simpan')"
          class="mobile-form-btn save-btn"
          unelevated
          :disable="disableSaveButton"
          @click="save"
        />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { computed } from 'vue'
import { useClassStore } from 'src/stores/class'
import { useScheduleStore } from 'src/stores/schedule'
import { maximizedDialog, cardDialog } from '../../composables/screen'

export default {
  name: 'LessonEditForm',
  setup() {
    const store = useScheduleStore()
    const classStore = useClassStore()

    const setLesson = (model) => (store.lesson.detail.lesson_id = model.value)
    const setTeacher = (model) => (store.lesson.detail.teacher_id = model.value)

    const save = () => {
      store.saveLesson({
        data: store.lesson.detail,
        edit: true,
        id: store.lesson.detail.lessons_grade_id,
      })
    }

    return {
      save,
      store,
      classStore,
      setLesson,
      setTeacher,
      maximizedDialog,
      cardDialog,
      error: computed(() => store.error),
      disableSaveButton: computed(() => store.helper.disableSaveButton),
    }
  },
}
</script>
