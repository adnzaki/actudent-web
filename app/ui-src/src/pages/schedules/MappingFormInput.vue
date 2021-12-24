<template>
  <q-form class="q-gutter-md q-mb-md" v-if="!schedule.showLessonList" >
    <div v-if="schedule.showLessonInput">
      <dropdown-search 
        vuex-module="schedule"
        :selected="setLesson"
        :label="$t('jadwal_label_pilih_mapel')"
        :list="$store.state.schedule.schedule.lessonOptions"
        :options-value="{ label: 'text', value: 'id' }"
        load-on-route
        class="q-mb-md"
      />       
      <dropdown-search 
        vuex-module="schedule"
        :selected="setRoom"
        :label="$t('jadwal_label_pilih_ruang')"
        :list="$store.state.schedule.rooms"
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
import { mapState, useStore } from 'vuex'
import { ref } from 'vue'
import { useI18n } from 'vue-i18n'
import MappingFormSelector from './MappingFormSelector.vue'
import { useQuasar } from 'quasar'

export default {
  name: 'MappingAddNormal',
  components: { MappingFormSelector },
  computed: {
    ...mapState('schedule', {
      error: state => state.error,
      schedule: state => state.schedule
    })
  },
  setup() {
    const store = useStore()
    const { t } = useI18n()
    const $q = useQuasar()

    let formValue = {
      lesson: '',
      room: '',
    }

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
      if(store.state.schedule.schedule.isBreak) {
        if(breakDuration.value.match(/[^0-9]/) === null
          && breakDuration.value !== ''
          && breakDuration.value !== '0') {
          store.commit('schedule/pushLesson', breakDuration.value)
        }
      } else {
        if(formValue.lesson !== '' && formValue.room !== '' && duration.value !== null) {
          store.commit('schedule/pushLesson', formValue)
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
      setLesson,
      setRoom,
      duration,
      durationOptions,
      pushLesson,
      setDuration,
      breakDuration,
      breakLabel: `${t('jadwal_istirahat')} (${t('jadwal_menit')})`
    }
  }
}
</script>
