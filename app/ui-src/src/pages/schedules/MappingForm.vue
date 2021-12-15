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
        <q-input standout dense disable
          v-for="(item, index) in data" :key="index"
          v-model="item.text"
          class="q-mb-xs">
          <template v-slot:after>
            <q-btn round dense flat icon="delete" color="negative" />
          </template>
        </q-input>      
        <div class="column items-center q-mt-md">
          <q-btn round color="primary" icon="add" />              
        </div>
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
import { useRoute } from 'vue-router'
import { maximizedDialog, cardDialog } from '../../composables/screen'
import { mapState, useStore } from 'vuex'

export default {
  name: 'MappingForm',
  computed: {
    ...mapState('schedule', {
      error: state => state.error,
      disableSaveButton: state => state.helper.disableSaveButton,
      data: state => state.schedule.lessonsInput,
    }),
  },
  setup() {
    const store = useStore()
    const route = useRoute()

    let formValue = {
      lesson_id: '',
      teacher_id: ''
    }

    const formData = ref(formValue)

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
    
    const save = () => {
      // store.dispatch('schedule/saveLesson', {
      //   data: formData.value,
      //   edit: false,
      //   id: null
      // })
    }

    return {
      formData,
      save,
      maximizedDialog, cardDialog,
      formOpen,
    }
  }
}
</script>
