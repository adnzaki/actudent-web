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
import { ref, onMounted } from 'vue'

export default {
  components: {
    FullCalendar 
  },
  setup() {
    const initialView = ref('dayGridMonth')
    const fullCalendar = ref(null)
    onMounted(() => {
      const fcApi = fullCalendar.value.getApi()
      console.log(fcApi.getEventSources())
    })
    return {
      calendarOptions: {
        plugins: [ dayGridPlugin, interactionPlugin ],
        initialView: initialView.value,
        events: [
          {
            title  : 'event1',
            start  : '2022-05-01'
          },
          {
            title  : 'event2',
            start  : '2022-05-05',
            end    : '2022-05-07'
          },
        ],
        weekend: true,
        eventClick({ event }) {
          alert(event.title)
        }
      },
      fullCalendar
    }
  }
}
</script>