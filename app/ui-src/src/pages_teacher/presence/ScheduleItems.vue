<template>
  <div>
    <q-scroll-area class="no-paging-scroll-area">
      <q-markup-table bordered>
        <thead>
          <tr>
            <th class="text-center cursor-pointer mobile-hide">#</th>
            <th class="text-left cursor-pointer mobile-hide">
              {{ $t('absensi_mapel') }}
            </th>
            <th class="text-left cursor-pointer mobile-hide">
              {{ $t('kelas_nama') }}
            </th>
            <th class="text-left cursor-pointer mobile-only">
              {{ $t('guru_jadwal_mengajar') }}
            </th>
            <th class="text-left cursor-pointer mobile-hide">
              {{ $t('ruang_nama') }}
            </th>
            <th class="text-center cursor-pointer mobile-hide">
              {{ $t('jadwal_label_alokasi') }}
            </th>
            <th class="text-left cursor-pointer mobile-hide">
              {{ $t('jadwal_waktu') }}
            </th>
            <th class="text-left">{{ $t('aksi') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td class="text-center mobile-hide">{{ index + 1 }}</td>
            <td class="text-left mobile-hide">{{ item.lesson_name }}</td>
            <td class="text-left mobile-hide">{{ item.grade_name }}</td>
            <td
              class="text-left mobile-only cursor-pointer"
              @click="goToPresenceFilling(item)"
            >
              <strong>{{ item.lesson_name }} - {{ item.grade_name }}</strong
              ><br />
              {{ item.room_name }}<br />
              {{ item.duration }} JP ({{ item.schedule_start }} -
              {{ item.schedule_end }})
            </td>
            <td class="text-left mobile-hide">{{ item.room_name }}</td>
            <td class="text-center mobile-hide">{{ item.duration }} JP</td>
            <td class="text-left mobile-hide">
              {{ item.schedule_start }} - {{ item.schedule_end }}
            </td>
            <td class="text-left">
              <q-btn
                class="action-btn"
                :round="round"
                icon="fact_check"
                @click="goToPresenceFilling(item)"
              >
                <btn-tooltip :label="$t('absensi_isi_kehadiran')" />
              </q-btn>
            </td>
          </tr>
        </tbody>
      </q-markup-table>
    </q-scroll-area>
    <q-separator />
    <schedule-detail />
  </div>
</template>

<script>
import { computed } from 'vue'
import { useQuasar } from 'quasar'
import { useRouter } from 'vue-router'
import ScheduleDetail from './ScheduleDetail.vue'
import { checkColWidth } from 'src/composables/screen'
import { usePresenceStore } from 'src/stores/presence'

export default {
  name: 'ScheduleItems',
  components: { ScheduleDetail },
  setup() {
    const $q = useQuasar()
    const router = useRouter()
    const store = usePresenceStore()

    return {
      store,
      checkColWidth,
      data: computed(() => store.teacherSchedules),
      goToPresenceFilling(detail) {
        const activeDate = computed(() => store.helper.activeDate)
        store.className = detail.grade_name
        store.lessonName = detail.lesson_name
        store.scheduleID = detail.schedule_id

        // store lesson name to localStorage, it is safe
        const date = new Date(activeDate.value)
        localStorage.setItem('date', date.getDay())
        localStorage.setItem('class', detail.grade_name)
        localStorage.setItem('lesson', detail.lesson_name)

        router.push(
          `presence/fill/${detail.schedule_id}/${detail.grade_id}/${activeDate.value}`
        )
      },
      showDetail(detail) {
        store.showScheduleDetail = true

        store.scheduleDetail = {
          lesson: detail.lesson_name,
          grade: detail.grade_name,
          room: detail.room_name,
          duration: detail.duration,
          start: detail.schedule_start,
          end: detail.schedule_end,
        }
      },
      round: $q.screen.lt.sm ? true : false,
    }
  },
}
</script>
