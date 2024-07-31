<template>
  <div></div>
  <div class="col-12 col-sm-6 q-mt-md q-pr-sm">
    <q-input v-model="selectedDate" outlined dense readonly>
      <template v-slot:append>
        <q-icon name="event" class="cursor-pointer">
          <q-popup-proxy
            ref="qDateProxy"
            cover
            transition-show="scale"
            transition-hide="scale"
          >
            <q-date
              v-model="dateValue"
              @update:model-value="dateChanged"
              today-btn
            >
              <div class="row items-center justify-end">
                <q-btn
                  v-close-popup
                  :label="$t('tutup')"
                  color="primary"
                  flat
                />
              </div>
            </q-date>
          </q-popup-proxy>
        </q-icon>
      </template>
    </q-input>
  </div>
  <div class="col-12 col-sm-6 q-mt-sm q-pr-sm">
    <dropdown-search
      @selected="getPresence"
      :label="$t('absensi_pilih_jadwal')"
      :list="store.schedule"
      :options-value="{ label: 'text', value: 'id' }"
      load-on-route
    />
  </div>
</template>

<script>
import { ref } from 'vue'
import { date } from 'quasar'
import { useRoute } from 'vue-router'
import { selectedLang } from '../../composables/date'
import { usePresenceStore } from 'src/stores/presence'

export default {
  name: 'ScheduleSelector',
  setup() {
    const route = useRoute()
    const store = usePresenceStore()

    const today = new Date()
    const dateValue = ref(today)
    const getDay = today.getDay()
    const activeDate = (val) => date.formatDate(val, 'YYYY-MM-DD')
    const selectedDate = ref(
      date.formatDate(dateValue.value, 'dddd, DD MMMM YYYY', selectedLang),
    )

    store.helper.activeDay = getDay
    store.helper.activeDate = activeDate(today)

    store.getSchedules(route.params.id)

    const dateChanged = (val, reason, details) => {
      const getDate = new Date(details.year, details.month - 1, details.day)
      selectedDate.value = date.formatDate(
        getDate,
        'dddd, DD MMMM YYYY',
        selectedLang,
      )

      store.helper.activeDay = getDate.getDay()
      store.helper.activeDate = activeDate(getDate)

      store.getSchedules(route.params.id)
      store.canFillJournal()

      if (store.scheduleID === '') {
        store.showJournalBtn = false
      } else {
        store.showJournalBtn = true
      }
    }

    store.canFillJournal()

    const getPresence = (model) => {
      store.scheduleID = model.value
      store.checkJournal()
      store.showJournalBtn = true
    }

    return {
      store,
      dateValue,
      dateChanged,
      getPresence,
      selectedDate,
    }
  },
}
</script>
