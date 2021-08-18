<template>
  <q-dialog v-model="$store.state.grade.showEditForm" 
    :maximized="maximizedDialog()"
    @hide="formClose">
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ getLang.kelas_edit_title }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">          
          <q-input outlined :label="getLang.kelas_label_nama" dense v-model="$store.state.grade.detail.grade_name" />
          <error :label="error.grade_name" />

          <search-teacher />

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
import SearchTeacher from './SearchTeacher.vue'

export default {
  name: 'EditClassForm',
  components: { SearchTeacher },
  computed: {
    ...mapState('grade', {
      error: state => state.error,
      disableSaveButton: state => state.helper.disableSaveButton
    }),
  },
  setup() {
    const store = useStore()
    const getLang = computed(() => inject('textLang')).value
    const selectedTeacher = computed(() => store.state.grade.selectedTeacher)
    
    const save = () => {
      store.state.grade.detail.teacher_id = selectedTeacher.value.id
      store.dispatch('grade/save', {
        data: store.state.grade.detail,
        lang: getLang.value,
        edit: true,
        id: store.state.grade.detail.grade_id
      })
    }

    const formClose = () => {
      store.state.grade.selectedTeacher = {
        id: '', name: ''
      }
    }

    return {
      save,
      maximizedDialog, cardDialog,
      getLang,
      formClose
    }
  }
}
</script>
