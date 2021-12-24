<template>
  <q-form class="q-gutter-md q-mb-md" v-if="schedule.showLessonInput">
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
    />  
    <q-select outlined dense 
      v-model="duration" 
      :options="durationOptions" 
      :label="$t('jadwal_durasi')"
      @update:model-value="setDuration" />

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

    let formValue = {
      lesson: '',
      room: '',
      duration: 0
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

    const pushLesson = () => {
      if(formValue.lesson !== '' && formValue.room !== '' && formValue.duration !== 0) {
        store.commit('schedule/pushLesson', formValue)
        formValue.lesson = ''
        formValue.room = ''
      }

      store.state.schedule.schedule.showLessonInput = false
      store.state.schedule.schedule.showLessonList = true
      store.state.schedule.helper.disableSaveButton = false
    }
    
    return {
      setLesson,
      setRoom,
      duration,
      durationOptions,
      pushLesson,
      setDuration
    }
  }
}
</script>
