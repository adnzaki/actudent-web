<template>
  <div class="q-pa-md">
    <full-calendar ref="fullCalendar" :options="calendarOptions" />
  </div>
</template>

<script>
import '@fullcalendar/core/vdom' // solves problem with Vite
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import { ref, onMounted, computed } from 'vue'
import { useStore } from 'vuex'
import { date } from 'quasar'

export default {
  components: {
    FullCalendar 
  },
  setup() {
    const store = useStore()
    const initialView = ref('dayGridMonth')
    const initialDate = ref(date.formatDate(new Date(), 'YYYY-MM-DD'))
    const fullCalendar = ref(null)

    const defaultStart = date.startOfDate(new Date(), 'month')    
    const defaultStartDate = date.subtractFromDate(defaultStart, { days: 7 })
    const defaultEnd = date.addToDate(defaultStart, { days: 14, months: 1 })

    // formatting in one function
    const formatDate = v => date.formatDate(v, 'YYYY-MM-DD')

    store.dispatch('agenda/getEvents', {
      view: initialView.value,
      start: formatDate(defaultStartDate),
      end: formatDate(defaultEnd)
    })    

    onMounted(() => {
      const fcApi = fullCalendar.value.getApi()
      
      const prevBtn = document.querySelector('button.fc-prev-button')
      const nextBtn = document.querySelector('button.fc-next-button')
      const todayBtn = document.querySelector('button.fc-today-button')
      
      prevBtn.addEventListener('click', () => navDate())
      nextBtn.addEventListener('click', () => navDate())
      todayBtn.addEventListener('click', () => navDate())

      const navDate = () => {
        const startDate = date.startOfDate(fcApi.getDate(), 'months')
        store.dispatch('agenda/getEvents', {
          view: initialView.value,
          start: formatDate(date.subtractFromDate(startDate, { days: 7 })),
          end: formatDate(date.addToDate(startDate, { days: 14, months: 1 }))
        }) 
      }
    })

    return {
      calendarOptions: computed(() => {
        return {
          plugins: [ dayGridPlugin, interactionPlugin ],
          initialView: initialView.value,
          initialDate: initialDate.value,
          events: store.state.agenda.events,
          eventClick({ event }) {
            alert(event.title)
          }
        }
      }),
      fullCalendar
    }
  }
}
</script>