<template>
  <q-dialog
    no-backdrop-dismiss
    v-model="store.showAddForm"
    @before-show="formOpen"
    :maximized="maximizedDialog()"
  >
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ $t('kelas_add_title') }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">
          <q-input
            outlined
            :label="$t('kelas_label_nama')"
            dense
            v-model="formData.grade_name"
          />
          <ac-error :label="error.grade_name" />

          <dropdown-search
            @selected="setTeacher"
            :label="$t('kelas_wali')"
            :list="store.teachers"
            :options-value="{ label: 'staff_name', value: 'staff_id' }"
            load-on-route
          />
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
        />
        <q-btn
          :label="$t('simpan')"
          class="mobile-form-btn"
          :disable="disableSaveButton"
          @click="save"
          color="primary"
          padding="8px 20px"
        />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { ref, computed } from 'vue'
import { maximizedDialog, cardDialog } from '../../composables/screen'
import { useClassStore } from 'src/stores/class'

export default {
  name: 'AddClassForm',
  setup() {
    const store = useClassStore()

    let formValue = {
      grade_name: '',
      teacher_id: '',
    }

    const setTeacher = (model) => (formValue.teacher_id = model.value)

    const formData = ref(formValue)

    const formOpen = () => {
      // set default value
      formData.value.teacher_id = store.teacherId

      const saveStatus = computed(() => store.saveStatus)
      if (saveStatus.value === 200) {
        formValue = {
          grade_name: '',
          teacher_id: '',
        }

        store.saveStatus = 500
        formData.value = formValue
      }
    }

    const save = () => {
      store.save({
        data: formData.value,
        edit: false,
        id: null,
      })
    }

    return {
      store,
      formData,
      save,
      maximizedDialog,
      cardDialog,
      formOpen,
      setTeacher,
      error: computed(() => store.error),
      disableSaveButton: computed(() => store.helper.disableSaveButton),
    }
  },
}
</script>
