<template>
  <div class="mobile-only">
    <q-card class="q-px-md q-pt-sm" v-for="(item, index) in data" :key="index">
      <q-input
        class="q-mt-md"
        dense
        outlined
        readonly
        :model-value="$trim(item.name, 30)"
      >
        <template v-slot:after>
          <q-btn
            color="accent"
            v-if="item.type === 'staff'"
            icon="edit"
            @click="getDetail(item.schedule, item.name, item.id)"
          />
          <q-btn-group v-else>
            <q-btn
              @click="getDetail(item.schedule, item.name, item.id)"
              color="accent"
              icon="edit"
            />
            <q-btn color="accent" icon="sync" @click="sync(item.id)">
              <btn-tooltip :label="$t('siabsen_sync_jadwal')" />
            </q-btn>
          </q-btn-group>
        </template>
      </q-input>
      <q-markup-table bordered class="q-my-md">
        <tr>
          <td class="text-left">
            <q-checkbox
              disable
              :model-value="scheduleStatus(item.schedule, 0)"
              :label="$t('day1')"
            />
          </td>
          <td class="text-left">
            <q-checkbox
              disable
              :model-value="scheduleStatus(item.schedule, 1)"
              :label="$t('day2')"
            />
          </td>
          <td class="text-left">
            <q-checkbox
              disable
              :model-value="scheduleStatus(item.schedule, 2)"
              :label="$t('day3')"
            />
          </td>
        </tr>
        <tr>
          <td class="text-left">
            <q-checkbox
              disable
              :model-value="scheduleStatus(item.schedule, 3)"
              :label="$t('day4')"
            />
          </td>
          <td class="text-left">
            <q-checkbox
              disable
              :model-value="scheduleStatus(item.schedule, 4)"
              :label="$t('day5')"
            />
          </td>
          <td class="text-left">
            <q-checkbox
              disable
              :model-value="scheduleStatus(item.schedule, 5)"
              :label="$t('day6')"
            />
          </td>
        </tr>
        <tr>
          <td class="text-left">
            <q-checkbox
              disable
              :model-value="scheduleStatus(item.schedule, 6)"
              :label="$t('day7')"
            />
          </td>
        </tr>
      </q-markup-table>
    </q-card>
    <q-separator />
    <ss-paging v-model="store.current" />
  </div>
</template>

<script>
import { checkColWidth } from 'src/composables/screen'
import { computed } from 'vue'
import { useQuasar } from 'quasar'
import { usePagingStore } from 'ss-paging-vue'
import { useSiabsenStore } from 'src/stores/siabsen'

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
