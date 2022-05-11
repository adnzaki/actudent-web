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

    const startDate = date.startOfDate(new Date(), 'month')
    const endDate = date.endOfDate(new Date(), 'month')      

    store.dispatch('agenda/getEvents', {
      view: initialView.value,
      start: date.formatDate(startDate, 'YYYY-MM-DD'),
      end: date.formatDate(endDate, 'YYYY-MM-DD')
    })    

    onMounted(() => {
      const fcApi = fullCalendar.value.getApi()
      
      const prevBtn = document.querySelector('button.fc-prev-button')
      const nextBtn = document.querySelector('button.fc-next-button')
      
      prevBtn.addEventListener('click', () => {
        alert('Prev button clicked!')
      })

      nextBtn.addEventListener('click', () => {
        alert('Next button clicked!')
      })
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