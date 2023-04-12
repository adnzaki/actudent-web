<template>
  <q-option-group
    :options="options"
    type="radio"
    v-model="group"
    @update:model-value="updateForm"
  />
</template>

<script>
import { ref } from 'vue'
import { useI18n } from 'vue-i18n'
import { useScheduleStore } from 'src/stores/schedule'

export default {
  name: 'MappingFormSelector',
  setup () {
    const { t } = useI18n()
    const store = useScheduleStore()

    const options = [
      { label: t('jadwal_belajar'), value: 'normalList' },
      { label: t('jadwal_istirahat'), value: 'break', color: 'green' },
      { label: t('jadwal_opsi_inaktif'), value: 'inactiveList', color: 'red' }
    ]

    const updateForm = model => {
      if(model !== 'break') {
        store.schedule.isBreak = false
        store.schedule.showLessonInput = true
        store.schedule.lessonOptions = store.schedule[model]
        
        model === 'normalList'
          ? store.schedule.scheduleType = 'lesson'
          : store.schedule.scheduleType = 'inactive'
      } else {
        store.schedule.isBreak = true
        store.schedule.showLessonInput = false
        store.schedule.scheduleType = model
      }
    }

    return { 
      store,
      options,
      updateForm,
      group: ref(options[0].value),
    }
  }
}
</script>
