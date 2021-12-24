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
import { useStore } from 'vuex'

export default {
  name: 'MappingFormSelector',
  setup () {
    const { t } = useI18n()
    const store = useStore()

    const options = [
      { label: t('jadwal_belajar'), value: 'normalList' },
      { label: t('jadwal_istirahat'), value: 'break', color: 'green' },
      { label: t('jadwal_opsi_inaktif'), value: 'inactiveList', color: 'red' }
    ]

    const updateForm = model => {
      if(model.value !== 'break') {
        store.state.schedule.schedule.isBreak = false
        store.state.schedule.schedule.showLessonInput = true
        store.state.schedule.schedule.lessonOptions = store.state.schedule.schedule[model]
        
        model === 'normalList'
          ? store.state.schedule.schedule.scheduleType = 'lesson'
          : store.state.schedule.schedule.scheduleType = 'inactive'
      } else {
        store.state.schedule.schedule.isBreak = true
        store.state.schedule.schedule.showLessonInput = false
        store.state.schedule.schedule.scheduleType = model
      }
    }

    return {
      group: ref(options[0].value),
      options,
      updateForm
    }
  }
}
</script>
