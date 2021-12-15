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
import { useStore } from 'vuex'
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
  setup() {
    const store = useStore()
    const route = useRoute()

    return {
      
    }
  }
}
</script>
