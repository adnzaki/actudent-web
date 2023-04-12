<template>
  <q-form class="q-gutter-md q-mb-md" v-if="!schedule.showLessonList" >
    <div v-if="schedule.showLessonInput">
      <dropdown-search 
        :selected="setLesson"
        :label="$t('jadwal_label_pilih_mapel')"
        :list="store.schedule.lessonOptions"
        :options-value="{ label: 'text', value: 'id' }"
        load-on-route
        class="q-mb-md"
      />       
      <dropdown-search 
        :selected="setRoom"
        :label="$t('jadwal_label_pilih_ruang')"
        :list="store.rooms"
        :options-value="{ label: 'text', value: 'id' }"
        load-on-route
        class="q-mb-md"
      />  
      <q-select outlined dense 
        v-model="duration" 
        :options="durationOptions" 
        :label="$t('jadwal_durasi')"
        @update:model-value="setDuration" />
    </div>

    <q-input outlined :label="breakLabel" 
      dense v-model="breakDuration" 
      :rules="[
        val => val.match(/[^0-9]/) === null && val !== '' || $t('jadwal_err_istirahat_type'),
        val => val !== '0' || $t('jadwal_err_istirahat_time')
      ]"
      v-if="schedule.isBreak" />

    <mapping-form-selector />

    <div class="column items-center q-mt-md">
      <q-btn round color="green" icon="done" @click="pushLesson">
        <q-tooltip anchor="top middle" self="bottom middle" :offset="[10, 10]">
          {{ $t('selesai') }}
        </q-tooltip>
      </q-btn>
    </div>

  </q-form>
</template>

<script>
import { ref } from 'vue'
import { useI18n } from 'vue-i18n'
import { useQuasar } from 'quasar'
import { useScheduleStore } from 'src/stores/schedule'
import MappingFormSelector from './MappingFormSelector.vue'

export default {
  name: 'MappingFormInput',
  components: { MappingFormSelector },
  setup() {
    const store = useScheduleStore()
    const { t } = useI18n()
    const $q = useQuasar()

    let formValue = {
      lesson: '',
      room: '',
    }

    // set default option
    formValue.lesson = store.schedule.defaultLesson
    formValue.room = store.schedule.defaultRoom

    const setLesson = model => formValue.lesson = model
    const setRoom = model => formValue.room = model

    const duration = ref(null)
    const durationValues = [1, 2, 3, 4]
    const durationOptions = ref([])

    durationValues.forEach(item => {
      durationOptions.value.push({ 
        label: `${item} ${t('jadwal_jam_pelajaran')}`, 
        value: item 
      })
    })

    const setDuration = model => formValue.duration = model

    const breakDuration = ref('10')

    const pushLesson = () => {
      if(store.schedule.isBreak) {
        if(breakDuration.value.match(/[^0-9]/) === null
          && breakDuration.value !== ''
          && breakDuration.value !== '0') {
          store.pushLesson(breakDuration.value)
        }
      } else {
        if(formValue.lesson !== '' && formValue.room !== '' && duration.value !== null) {
          store.pushLesson(formValue)
          formValue.lesson = ''
          formValue.room = ''
        } else {
          $q.notify({
            message: t('jadwal_save_error'),
            color: 'negative',
            position: 'center',
            timeout: 3000,
          })
        }
      }
    }
    
    return { 
      store,
      setRoom,
      duration,
      setLesson,
      pushLesson,
      setDuration,
      breakDuration,
      durationOptions,
      error: computed(() => store.error),
      schedule: computed(() => store.schedule),
      breakLabel: `${t('jadwal_istirahat')} (${t('jadwal_menit')})`,
    }
  }
}
</script>
