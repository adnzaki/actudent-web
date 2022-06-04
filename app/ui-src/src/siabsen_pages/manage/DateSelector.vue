<template>
  <div :class="['col-12 col-md-5 q-mt-md', pr()]">
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
import { ref } from 'vue'
import { useStore } from 'vuex'
import { date, useQuasar } from 'quasar'
import { selectedLang } from '../../composables/date'

export default {
  name: 'DateSelector',
  setup() {
    const store = useStore()
    const $q = useQuasar()
    const today = new Date()
    const dateValue = ref(today)
    const selectedDate = ref(date.formatDate(dateValue.value, 'dddd, DD MMMM YYYY', selectedLang))
    const activeDate = val => date.formatDate(val, 'YYYY-MM-DD')

    store.state.siabsen.activeDate = activeDate(today)
    store.dispatch('siabsen/getStaffPresence')

    const dateChanged = (val, reason, details) => {
      const getDate = new Date(details.year, details.month - 1, details.day)
      selectedDate.value = date.formatDate(getDate, 'dddd, DD MMMM YYYY', selectedLang)
      store.state.siabsen.activeDate = activeDate(getDate)

      store.dispatch('siabsen/getStaffPresence')
    }
    
    return {
      pr: () => $q.screen.lt.md ? '' : 'q-pr-sm',
      selectedDate,
      dateValue,
      dateChanged, 
    }
  }
}
</script>
