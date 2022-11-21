<template>
  <div class="mobile-only">
    <q-card class="q-px-md q-pt-sm" v-for="(item, index) in data" :key="index">
      <q-input class="q-mt-md" dense outlined readonly :model-value="$trim(item.name, 30)">
        <template v-slot:after>
          <q-btn color="accent" v-if="item.type === 'staff'" icon="edit" @click="getDetail(item.schedule, item.name, item.id)" />
          <q-btn-group v-else>
            <q-btn @click="getDetail(item.schedule, item.name, item.id)" color="accent" icon="edit" />
            <q-btn color="accent" icon="sync" @click="sync(item.id)">
              <btn-tooltip :label="$t('siabsen_sync_jadwal')" />
            </q-btn>
          </q-btn-group>
        </template>
      </q-input>
        <q-markup-table bordered class="q-my-md">
          <tr>
            <td class="text-left">
              <q-checkbox disable :model-value="scheduleStatus(item.schedule, 0)" :label="$t('day1')" />
            </td>
            <td class="text-left">
              <q-checkbox disable :model-value="scheduleStatus(item.schedule, 1)" :label="$t('day2')" />
            </td>
            <td class="text-left">
              <q-checkbox disable :model-value="scheduleStatus(item.schedule, 2)" :label="$t('day3')" />
            </td>
          </tr>
          <tr>
            <td class="text-left">
              <q-checkbox disable :model-value="scheduleStatus(item.schedule, 3)" :label="$t('day4')" />
            </td>
            <td class="text-left">
              <q-checkbox disable :model-value="scheduleStatus(item.schedule, 4)" :label="$t('day5')" />
            </td>
            <td class="text-left">
              <q-checkbox disable :model-value="scheduleStatus(item.schedule, 5)" :label="$t('day6')" />
            </td>
          </tr>
          <tr>
            <td class="text-left">
              <q-checkbox disable :model-value="scheduleStatus(item.schedule, 6)" :label="$t('day7')" />
            </td>
          </tr>
        </q-markup-table>
    </q-card>      
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

    const getDetail = (schedule, name, id) => {
      store.dispatch('siabsen/getDetailSchedule', { schedule, name, id })
    }

    return {
      sync: id => store.dispatch('siabsen/promptSync', id),
      getDetail,
      scheduleStatus(src, val) {
        if(src !== undefined) {
          return src[ 'day'+val ]['value'] !== 'null' ? true : false
        } else {
          return false
        }
      },
      data: computed(() => store.state.siabsen.paging.data),
      checkColWidth,
    }
  }
}
</script>