<template>
  <div class="q-px-md q-pb-md" style="margin-top: -20px">
    <full-calendar ref="fullCalendar" :options="calendarOptions" />
  </div>
  <q-page-sticky position="bottom-right" :offset="fabPos" class="force-elevated"
    v-if="$q.cookies.get(conf.userType) === '1'">
    <q-btn fab icon="add" color="secondary" 
      @click="store.showForm = true" />    
  </q-page-sticky>
</template>

<script>
import '@fullcalendar/core/vdom' // solves problem with Vite
import { userLang } from 'boot/i18n'
import { date, useQuasar } from 'quasar'
import listPlugin from '@fullcalendar/list'
import FullCalendar from '@fullcalendar/vue3'
import { conf } from 'src/composables/common'
import id from '@fullcalendar/core/locales/id'
import { ref, onMounted, computed } from 'vue'
import en from '@fullcalendar/core/locales/en-gb'
import dayGridPlugin from '@fullcalendar/daygrid'
import { useAgendaStore } from 'src/stores/agenda'
import interactionPlugin from '@fullcalendar/interaction'
import { fabPos, draggingFab, moveFab } from 'src/composables/fab'

export default {
  components: {
    FullCalendar 
  },
  setup() {
    const $q = useQuasar()
    const store = useAgendaStore()
    const fullCalendar = ref(null)
    const initialDate = ref(date.formatDate(new Date(), 'YYYY-MM-DD'))
    const initialView = $q.screen.lt.sm ? ref('listMonth') : ref('dayGridMonth')

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
      store.calendar.view = initialView.value
      store.calendar.start = formatDate(defaultStartDate)
      store.calendar.end = formatDate(defaultEnd)

      store.getEvents({
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
        store.calendar.view = initialView.value
        store.calendar.start = nextStartDate
        store.calendar.end = nextEndDate

        store.getEvents({
          view: initialView.value,
          start: nextStartDate,
          end: nextEndDate
        }) 
      }
    })

    const titleFormat = computed(() => {
      return $q.screen.lt.sm 
              ? { year: 'numeric', month: '2-digit' }
              : { year: 'numeric', month: 'long' }
    })

    return { 
      conf,
      store,
      fullCalendar,
      fabPos, draggingFab, moveFab,
      calendarOptions: computed(() => {
        return {
          firstDay: 0,
          height: 'auto',
          events: store.events,
          locale: locales[userLang],
          eventClick({ event }) {
            store.getDetail(event.id)
          },
          titleFormat: titleFormat.value,
          initialView: initialView.value,
          initialDate: initialDate.value,
          plugins: [ dayGridPlugin, interactionPlugin, listPlugin ],
          headerToolbar: {
            left: 'title',
            right: 'today prev,next'
          },
        }
      }),
    }
  }
}
</script>