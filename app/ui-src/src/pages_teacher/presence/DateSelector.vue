<template>
  <div class="col-12 col-sm-6 q-mt-md q-pr-sm">
    <q-input v-model="selectedDate" outlined dense readonly>
      <template v-slot:append>
        <q-icon name="event" class="cursor-pointer">
          <q-popup-proxy ref="qDateProxy" cover transition-show="scale" transition-hide="scale">
            <q-date v-model="dateValue" @update:model-value="dateChanged" today-btn>
              <div class="row items-center justify-end">
                <q-btn v-close-popup :label="$t('tutup')" color="primary" flat />
              </div>
            </q-date>
          </q-popup-proxy>
        </q-icon>
      </template>
    </q-input>   
  </div>
</template>

<script>
import { date } from 'quasar'
import { ref, onMounted } from 'vue'
import { selectedLang } from 'src/composables/date'
import { usePresenceStore } from 'src/stores/presence'

export default {
  name: 'DateSelector',
  setup() {
    const store = usePresenceStore()
    const today = new Date()
    const dateValue = ref(today)
    const selectedDate = ref(date.formatDate(dateValue.value, 'dddd, DD MMMM YYYY', selectedLang))
    const getDay = today.getDay()
    const activeDate = val => date.formatDate(val, 'YYYY-MM-DD')

    store.helper.activeDay = getDay
    store.helper.activeDate = activeDate(today)

    const dateChanged = (val, reason, details) => {
      const getDate = new Date(details.year, details.month - 1, details.day)
      selectedDate.value = date.formatDate(getDate, 'dddd, DD MMMM YYYY', selectedLang)
      store.helper.activeDay = getDate.getDay()
      store.helper.activeDate = activeDate(getDate)

      store.getTeacherSchedules()
    }

    onMounted(() => {
      setTimeout(() => store.getTeacherSchedules(), 500)
    })
    
    return {
      dateValue,
      dateChanged, 
      selectedDate,
    }
  }
}
</script>
