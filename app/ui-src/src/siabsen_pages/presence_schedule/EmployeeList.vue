<template>
  <div class="mobile-hide">
    <q-scroll-area class="table-scroll-area">
      <q-markup-table separator="cell" bordered wrap-cells>
        <thead class="mobile-hide">
          <tr>
            <th rowspan="2" class="text-center cursor-pointer mobile-hide">
              #
            </th>
            <th rowspan="2" class="text-left cursor-pointer">
              {{ $t('staff_nama') }}
            </th>
            <th colspan="7" class="text-center cursor-pointer mobile-hide">
              {{ $t('siabsen_jadwal') }}
            </th>
            <th rowspan="2" class="text-center mobile-hide">
              {{ $t('aksi') }}
            </th>
          </tr>
          <tr>
            <th class="text-center cursor-pointer mobile-hide">
              {{ $trim($t('day1'), 3, false) }}
            </th>
            <th class="text-center cursor-pointer mobile-hide">
              {{ $trim($t('day2'), 3, false) }}
            </th>
            <th class="text-center cursor-pointer mobile-hide">
              {{ $trim($t('day3'), 3, false) }}
            </th>
            <th class="text-center cursor-pointer mobile-hide">
              {{ $trim($t('day4'), 3, false) }}
            </th>
            <th class="text-center cursor-pointer mobile-hide">
              {{ $trim($t('day5'), 3, false) }}
            </th>
            <th class="text-center cursor-pointer mobile-hide">
              {{ $trim($t('day6'), 3, false) }}
            </th>
            <th class="text-center cursor-pointer mobile-hide">
              {{ $trim($t('day7'), 3, false) }}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td class="text-center mobile-hide">
              {{ paging.itemNumber(index) }}
            </td>
            <td class="text-left mobile-hide">{{ item.name }}</td>
            <td class="text-center">
              <q-checkbox
                :style="dayMarginLeft"
                disable
                :model-value="scheduleStatus(item.schedule, 0)"
              />
            </td>
            <td class="text-center">
              <q-checkbox
                :style="dayMarginLeft"
                disable
                :model-value="scheduleStatus(item.schedule, 1)"
              />
            </td>
            <td class="text-center">
              <q-checkbox
                :style="dayMarginLeft"
                disable
                :model-value="scheduleStatus(item.schedule, 2)"
              />
            </td>
            <td class="text-center">
              <q-checkbox
                :style="dayMarginLeft"
                disable
                :model-value="scheduleStatus(item.schedule, 3)"
              />
            </td>
            <td class="text-center">
              <q-checkbox
                :style="dayMarginLeft"
                disable
                :model-value="scheduleStatus(item.schedule, 4)"
              />
            </td>
            <td class="text-center">
              <q-checkbox
                :style="dayMarginLeft"
                disable
                :model-value="scheduleStatus(item.schedule, 5)"
              />
            </td>
            <td class="text-center">
              <q-checkbox
                :style="dayMarginLeft"
                disable
                :model-value="scheduleStatus(item.schedule, 6)"
              />
            </td>

            <td class="text-left" v-if="item.type === 'staff'">
              <q-btn
                @click="getDetail(item.schedule, item.name, item.id)"
                :class="actionButton"
                icon="edit"
              />
            </td>
            <td class="text-left" v-else>
              <q-btn-group>
                <q-btn
                  @click="getDetail(item.schedule, item.name, item.id)"
                  :class="actionButton"
                  icon="edit"
                />
                <q-btn :class="actionButton" icon="sync" @click="sync(item.id)">
                  <btn-tooltip :label="$t('siabsen_sync_jadwal')" />
                </q-btn>
              </q-btn-group>
            </td>
          </tr>
        </tbody>
      </q-markup-table>
    </q-scroll-area>
    <q-separator />
    <ss-paging v-model="store.current" />
  </div>
</template>

<script>
import { checkColWidth } from 'src/composables/screen'
import { computed, ref } from 'vue'
import { useQuasar } from 'quasar'
import { usePagingStore } from 'ss-paging-vue'
import { useSiabsenStore } from 'src/stores/siabsen'
import { actionButton } from 'src/composables/mode'

export default {
  setup() {
    const store = useSiabsenStore()
    const paging = usePagingStore()
    const $q = useQuasar()

    store.getStaffScheduleList()

    const getDetail = (schedule, name, id) => {
      store.getDetailSchedule({ schedule, name, id })
    }

    return {
      store,
      paging,
      actionButton,
      scheduleStatus(src, val) {
        if (src !== undefined) {
          return src['day' + val]['value'] !== 'null' ? true : false
        } else {
          return false
        }
      },
      sync: (id) => store.promptSync(id),
      dayMarginLeft: computed(() =>
        $q.screen.lt.sm ? { marginLeft: '-10px' } : {}
      ),
      getDetail,
      data: computed(() => paging.state.data),
      checkColWidth,
    }
  },
}
</script>
