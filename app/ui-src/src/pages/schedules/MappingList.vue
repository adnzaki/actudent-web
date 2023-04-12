<template>  
  <div class="row q-pb-md">
    <mapping-day :day="$t('day1')" target="senin" />
    <mapping-day :day="$t('day2')" target="selasa" />
    <mapping-day :day="$t('day3')" target="rabu" />
  </div>
  <div class="row q-pb-md">
    <mapping-day :day="$t('day4')" target="kamis" />
    <mapping-day :day="$t('day5')" target="jumat" />
    <mapping-day :day="$t('day6')" target="sabtu" />
  </div>
  <mapping-form />
</template>

<script>
import { useRoute } from 'vue-router'
import MappingDay from './MappingDay.vue'
import MappingForm from './MappingForm.vue'
import { useScheduleStore } from 'src/stores/schedule'

export default {
  name: 'MappingList',
  components: {
    MappingDay,
    MappingForm
  },
  setup() {
    const route = useRoute()
    const store = useScheduleStore()

    store.getRooms()
    store.getSchedules(route.params.id)
    store.getLessonsList(route.params.id)
    store.getLessonsForSchedule(route.params.id)

    return { store }
  }
}
</script>
