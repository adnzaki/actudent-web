<template>
  <div class="mobile-only">
    <q-scroll-area class="table-scroll-area">
      <q-card class="q-px-md q-pt-sm" v-for="(item, index) in data" :key="index">
        <q-input class="q-mt-md" dense outlined readonly v-model="item.name">
          <template v-slot:after>
            <q-btn color="accent" icon="edit" @click="getDetail(item.schedule)" />
          </template>
        </q-input>
          <q-markup-table bordered class="q-my-md">
            <tr>
              <td class="text-left">
                <q-checkbox disable :model-value="scheduleStatus(item.schedule.day1.value)" :label="$t('day1')" />
              </td>
              <td class="text-left">
                <q-checkbox disable :model-value="scheduleStatus(item.schedule.day2.value)" :label="$t('day2')" />
              </td>
              <td class="text-left">
                <q-checkbox disable :model-value="scheduleStatus(item.schedule.day3.value)" :label="$t('day3')" />
              </td>
            </tr>
            <tr>
              <td class="text-left">
                <q-checkbox disable :model-value="scheduleStatus(item.schedule.day4.value)" :label="$t('day4')" />
              </td>
              <td class="text-left">
                <q-checkbox disable :model-value="scheduleStatus(item.schedule.day5.value)" :label="$t('day5')" />
              </td>
              <td class="text-left">
                <q-checkbox disable :model-value="scheduleStatus(item.schedule.day6.value)" :label="$t('day6')" />
              </td>
            </tr>
          </q-markup-table>
      </q-card>      
    </q-scroll-area>
    <q-separator/>
    <ss-paging vuex-module="siabsen" />
  </div>
</template>

<script>
import { useRouter } from 'vue-router'
import { useStore } from 'vuex'
import { checkColWidth } from 'src/composables/screen'
import { computed } from 'vue'
import { useQuasar } from 'quasar'

export default {
  setup () {
    const router = useRouter()
    const store = useStore()
    const $q = useQuasar()

    store.dispatch('siabsen/getStaffScheduleList')

    const scheduleStatus = val => {
      return val !== 'null' ? true : false
    }

    const getDetail = schedule => {
      store.dispatch('siabsen/getDetailSchedule', schedule)
    }

    return {
      getDetail,
      scheduleStatus,
      data: computed(() => store.state.siabsen.paging.data),
      checkColWidth,
    }
  }
}
</script>