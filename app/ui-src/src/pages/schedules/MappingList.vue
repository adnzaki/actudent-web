<template>  
  <!-- <q-page padding>
  </q-page> -->
  <div class="row q-pb-md">
    <mapping-day :day="$t('day1')" :data="schedules.senin" />
    <mapping-day :day="$t('day2')" :data="schedules.selasa" />
    <mapping-day :day="$t('day3')" :data="schedules.rabu" />
  </div>
  <div class="row q-pb-md">
    <mapping-day :day="$t('day4')" :data="schedules.kamis" />
    <mapping-day :day="$t('day5')" :data="schedules.jumat" />
    <mapping-day :day="$t('day6')" :data="schedules.sabtu" />
  </div>
</template>

<script>
import { mapState, useStore } from 'vuex'
import { useRoute } from 'vue-router'
import MappingDay from './MappingDay.vue'

export default {
  name: 'MappingList',
  components: {
    MappingDay
  },
  created() {
    setTimeout(() => {
      this.$store.commit('schedule/getSchedules', this.$route.params.id)  
    }, 500)
  },
  computed: {
    ...mapState('schedule', {
      schedules: state => state.schedule.list,
    })
  },
  setup() {
    const store = useStore()
    const route = useRoute()

    return {
      
    }
  }
}
</script>
