<template>
  <div class="mobile-hide">
    <q-scroll-area class="table-scroll-area">
      <q-markup-table bordered>
        <thead class="mobile-hide">
          <tr>
            <th rowspan="2" class="text-center cursor-pointer mobile-hide">#</th>
            <th rowspan="2" class="text-left cursor-pointer">{{ $t('staff_nama') }}</th>
            <th class="text-center cursor-pointer mobile-hide">{{ $t('siabsen_jadwal') }}</th>
            <th rowspan="2" class="text-left mobile-hide">{{ $t('aksi') }}</th>
          </tr>
          <tr>
            <th class="text-center cursor-pointer mobile-hide">{{ $trim($t('day1'), 3, false) }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td class="text-center mobile-hide">{{ $store.getters['siabsen/itemNumber'](index) }}</td>
            <td class="text-left mobile-hide">{{ item.name }}</td>
            <td class="text-left q-gutter-xs mobile-hide">
              <q-checkbox :style="dayMarginLeft" disable :model-value="scheduleStatus(item.schedule, 0)" :label="$t('day1')" />
              <q-checkbox :style="dayMarginLeft" disable :model-value="scheduleStatus(item.schedule, 1)" :label="$t('day2')" />
              <q-checkbox :style="dayMarginLeft" disable :model-value="scheduleStatus(item.schedule, 2)" :label="$t('day3')" />
              <q-checkbox :style="dayMarginLeft" disable :model-value="scheduleStatus(item.schedule, 3)" :label="$t('day4')" />
              <q-checkbox :style="dayMarginLeft" disable :model-value="scheduleStatus(item.schedule, 4)" :label="$t('day5')" />
              <q-checkbox :style="dayMarginLeft" disable :model-value="scheduleStatus(item.schedule, 5)" :label="$t('day6')" />
            </td>
            <td class="text-left" v-if="item.type === 'staff'">
              <q-btn @click="getDetail(item.schedule, item.name, item.id)" color="accent" icon="edit" />
            </td>
            <td class="text-left" v-else>
              <q-btn-group>
                <q-btn @click="getDetail(item.schedule, item.name, item.id)" color="accent" icon="edit" />
                <q-btn color="accent" icon="sync" @click="sync(item.id)">
                  <btn-tooltip :label="$t('siabsen_sync_jadwal')" />
                </q-btn>
              </q-btn-group>
            </td>
          </tr>
        </tbody>
      </q-markup-table>
    </q-scroll-area>
    <q-separator/>
    <ss-paging vuex-module="siabsen" />
  </div>
</template>

<script>
import { useRouter } from 'vue-router'
import { useStore } from 'vuex'
import { checkColWidth } from 'src/composables/screen'
import { computed, ref } from 'vue'
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
      scheduleStatus(src, val) {
        if(src !== undefined) {
          return src[ 'day'+val ]['value'] !== 'null' ? true : false
        } else {
          return false
        }
      },
      sync: id => store.dispatch('siabsen/promptSync', id),
      dayMarginLeft: computed(() => $q.screen.lt.sm ? { marginLeft: '-10px' } : {}),
      getDetail,
      data: computed(() => store.state.siabsen.paging.data),
      checkColWidth,
    }
  }
} 
</script>