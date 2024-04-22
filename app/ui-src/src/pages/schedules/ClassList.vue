<template>
  <div>
    <q-scroll-area class="table-scroll-area">
      <q-markup-table bordered>
        <thead>
          <tr>
            <th class="text-center cursor-pointer">#</th>
            <th
              class="text-left cursor-pointer"
              @click="paging.sortData('grade_name')"
            >
              {{ $t('kelas_nama') }} <sort-icon />
            </th>
            <th
              class="text-left cursor-pointer mobile-hide"
              @click="paging.sortData('staff_name')"
            >
              {{ $t('kelas_wali') }} <sort-icon />
            </th>
            <th class="text-left cursor-pointer mobile-hide">Shift</th>
            <th class="text-left">{{ $t('aksi') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td class="text-center">
              {{ paging.itemNumber(index) }}
            </td>
            <td class="text-left mobile-hide">{{ item.grade_name }}</td>
            <td class="text-left mobile-only">
              {{ $trim(item.grade_name, 30) }}
            </td>
            <td class="text-left mobile-hide">{{ item.staff_name }}</td>
            <td class="text-left mobile-hide">
              <q-badge
                :color="item.shift === 0 ? 'green' : 'orange'"
                :label="item.shift === 0 ? $t('pagi') : $t('siang')"
              />
            </td>
            <td class="text-left">
              <q-btn-group class="mobile-hide">
                <q-btn
                  :class="actionButton"
                  icon="list"
                  @click="showLessons(item.grade_id, item.grade_name)"
                  ><btn-tooltip :label="$t('jadwal_daftar_mapel')"
                /></q-btn>
                <q-btn
                  :class="actionButton"
                  icon="menu_book"
                  @click="showSchedules(item.grade_id, item.grade_name)"
                  ><btn-tooltip :label="$t('jadwal_jadwal_mapel')"
                /></q-btn>
                <q-btn
                  :class="actionButton"
                  icon="autorenew"
                  @click="store.switchShift(item.grade_id)"
                  ><btn-tooltip :label="$t('jadwal_tukar_shift')"
                /></q-btn>
              </q-btn-group>
              <q-btn round icon="more_vert" class="mobile-only" unelevated flat>
                <q-menu>
                  <q-list style="min-width: 200px">
                    <q-item
                      clickable
                      v-close-popup
                      @click="showLessons(item.grade_id, item.grade_name)"
                    >
                      <q-item-section>{{
                        $t('jadwal_daftar_mapel')
                      }}</q-item-section>
                    </q-item>
                    <q-separator />
                    <q-item
                      clickable
                      v-close-popup
                      @click="showSchedules(item.grade_id, item.grade_name)"
                    >
                      <q-item-section>{{
                        $t('jadwal_jadwal_mapel')
                      }}</q-item-section>
                    </q-item>
                    <q-separator />
                    <q-item
                      clickable
                      v-close-popup
                      @click="store.switchShift(item.grade_id)"
                    >
                      <q-item-section>{{
                        $t('jadwal_tukar_shift')
                      }}</q-item-section>
                    </q-item>
                  </q-list>
                </q-menu>
              </q-btn>
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
import { useQuasar } from 'quasar'
import { computed } from 'vue'
import { useRouter } from 'vue-router'
import { usePagingStore } from 'ss-paging-vue'
import { useScheduleStore } from 'src/stores/schedule'
import { checkColWidth } from 'src/composables/screen'
import { actionButton } from 'src/composables/mode'

export default {
  name: 'ClassList',
  setup() {
    const router = useRouter()
    const paging = usePagingStore()
    const store = useScheduleStore()
    const $q = useQuasar()

    store.getClassList()

    const showLessons = (gradeId, name) => {
      store.className = name
      router.push(`/schedules/lessons/${gradeId}`)
    }

    const showSchedules = (gradeId, name) => {
      store.className = name
      router.push(`/schedules/mapping/${gradeId}`)
    }

    return {
      store,
      paging,
      showLessons,
      actionButton,
      showSchedules,
      checkColWidth,
      data: computed(() => paging.state.data),
    }
  },
}
</script>
