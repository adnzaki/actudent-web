<template>  
  <div class="row q-pb-md">
    <mapping-day :day="$t('day1')" :data="schedules.senin" target="senin" />
    <mapping-day :day="$t('day2')" :data="schedules.selasa" target="selasa" />
    <mapping-day :day="$t('day3')" :data="schedules.rabu" target="rabu" />
  </div>
  <div class="row q-pb-md">
    <mapping-day :day="$t('day4')" :data="schedules.kamis" target="kamis" />
    <mapping-day :day="$t('day5')" :data="schedules.jumat" target="jumat" />
    <mapping-day :day="$t('day6')" :data="schedules.sabtu" target="sabtu" />
  </div>
  <mapping-form />
</template>

<script>
import { mapState, useStore } from 'vuex'
import { useRoute } from 'vue-router'
import MappingDay from './MappingDay.vue'
import MappingForm from './MappingForm.vue'

export default {
  name: 'MappingList',
  components: {
    MappingDay,
    MappingForm
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
