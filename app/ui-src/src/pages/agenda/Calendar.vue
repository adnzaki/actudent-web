<template>
  <div class="q-px-md q-pb-md" style="margin-top: -20px">
    <full-calendar ref="fullCalendar" :options="calendarOptions" />
  </div>
  <q-page-sticky position="bottom-right" :offset="fabPos" class="force-elevated"
    v-if="$q.cookies.get(conf.userType) === '1'">
    <q-btn fab icon="add" color="secondary" 
      @click="$store.state.agenda.showForm = true" />    
  </q-page-sticky>
</template>

<script>
import '@fullcalendar/core/vdom' // solves problem with Vite
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import id from '@fullcalendar/core/locales/id'
import en from '@fullcalendar/core/locales/en-gb'
import { ref, onMounted, computed } from 'vue'
import { useStore } from 'vuex'
import { date, useQuasar } from 'quasar'
import { userLang } from 'boot/i18n'
import { conf } from 'src/composables/common'
import { fabPos, draggingFab, moveFab } from 'src/composables/fab'

export default {
  components: {
    FullCalendar 
  },
  setup() {
    const store = useStore()
    const $q = useQuasar()
    const initialView = ref('dayGridMonth')
    const initialDate = ref(date.formatDate(new Date(), 'YYYY-MM-DD'))
    const fullCalendar = ref(null)

    const defaultStart = date.startOfDate(new Date(), 'month')    
    const defaultStartDate = date.subtractFromDate(defaultStart, { days: 7 })
    const defaultEnd = date.addToDate(defaultStart, { days: 14, months: 1 })

    const locales = {
      english: en,
      indonesia: id
    }

    // formatting in one function
    const formatDate = v => date.formatDate(v, 'YYYY-MM-DD')

    const initEvents = () => {
      store.state.agenda.calendar.view = initialView.value
      store.state.agenda.calendar.start = formatDate(defaultStartDate)
      store.state.agenda.calendar.end = formatDate(defaultEnd)

      store.dispatch('agenda/getEvents', {
        view: initialView.value,
        start: formatDate(defaultStartDate),
        end: formatDate(defaultEnd)
      })    
    }

    initEvents()

    onMounted(() => {
      const customPos = $q.screen.lt.sm ? 20 : 30
      fabPos.value = [ customPos, customPos ]
      const fcApi = fullCalendar.value.getApi()
      
      const prevBtn = document.querySelector('button.fc-prev-button')
      const nextBtn = document.querySelector('button.fc-next-button')
      const todayBtn = document.querySelector('button.fc-today-button')
      
      prevBtn.addEventListener('click', () => navDate())
      nextBtn.addEventListener('click', () => navDate())
      todayBtn.addEventListener('click', () => navDate())

      const navDate = () => {
        const startDate = date.startOfDate(fcApi.getDate(), 'months')
        const nextStartDate = formatDate(date.subtractFromDate(startDate, { days: 7 }))
        const nextEndDate = formatDate(date.addToDate(startDate, { days: 14, months: 1 }))
        store.state.agenda.calendar.view = initialView.value
        store.state.agenda.calendar.start = nextStartDate
        store.state.agenda.calendar.end = nextEndDate

        store.dispatch('agenda/getEvents', {
          view: initialView.value,
          start: nextStartDate,
          end: nextEndDate
        }) 
      }
    })

    return {
      conf,
      fabPos, draggingFab, moveFab,
      calendarOptions: computed(() => {
        return {
          plugins: [ dayGridPlugin, interactionPlugin ],
          height: 'auto',
          initialView: initialView.value,
          initialDate: initialDate.value,
          events: store.state.agenda.events,
          eventClick({ event }) {
            store.dispatch('agenda/getDetail', event.id)
          },
          locale: locales[userLang],
          firstDay: 0,
          headerToolbar: {
            left: 'title',
            right: 'today prev,next'
          }
        }
      }),
      fullCalendar
    }
  }
}
</script>