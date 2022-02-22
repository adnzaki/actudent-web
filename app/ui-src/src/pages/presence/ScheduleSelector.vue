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
  <div class="col-12 col-sm-6 q-mt-sm q-pr-sm">
    <dropdown-search 
      vuex-module="presence"
      :selected="getPresence"
      :label="$t('absensi_pilih_jadwal')"
      :list="$store.state.presence.schedule"
      :options-value="{ label: 'text', value: 'id' }"
      load-on-route
    />      
  </div>
</template>

<script>
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import { useStore } from 'vuex'
import { date, useQuasar } from 'quasar'
import { selectedLang } from '../../composables/date'

export default {
  name: 'ScheduleSelector',
  setup() {
    const $q = useQuasar()
    const route = useRoute()
    const store = useStore()
    const today = new Date()
    const dateValue = ref(today)
    const selectedDate = ref(date.formatDate(dateValue.value, 'dddd, DD MMMM YYYY', selectedLang))
    const getDay = today.getDay()
    const activeDate = ref(date.formatDate(today, 'YYYY-MM-DD'))

    store.state.presence.helper.activeDay = getDay
    store.dispatch('presence/getSchedules', {
      grade: route.params.id,
      date: activeDate.value
    })


    const dateChanged = (val, reason, details) => {
      const getDate = new Date(details.year, details.month - 1, details.day)
      selectedDate.value = date.formatDate(getDate, 'dddd, DD MMMM YYYY', selectedLang)
      activeDate.value = date.formatDate(getDate, 'YYYY-MM-DD')
      store.state.presence.helper.activeDate = activeDate.value
      store.state.presence.helper.activeDay = getDate.getDay()

      store.dispatch('presence/getSchedules', {
        grade: route.params.id,
        date: activeDate.value
      })


      if(store.state.presence.scheduleID === '') {
        store.state.presence.showJournalBtn = false
      } else {
        store.state.presence.showJournalBtn = true
      }
    }

    const getPresence = model => {
      store.state.presence.scheduleID = model.value
      store.dispatch('presence/checkJournal', activeDate.value)
      store.state.presence.showJournalBtn = true
    }
    
    return {
      selectedDate,
      dateValue,
      dateChanged, 
      getPresence,
    }
  }
}
</script>
