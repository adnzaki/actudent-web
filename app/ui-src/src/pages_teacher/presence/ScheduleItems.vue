<template>
  <div>
    <q-scroll-area class="no-paging-scroll-area">
      <q-markup-table bordered>
        <thead>
          <tr>
            <th class="text-center cursor-pointer mobile-hide">#</th>
            <th class="text-left cursor-pointer mobile-hide">{{ $t('absensi_mapel') }}</th>
            <th class="text-left cursor-pointer mobile-hide">{{ $t('kelas_nama') }}</th>
            <th class="text-left cursor-pointer mobile-only">{{ $t('guru_jadwal_mengajar') }}</th>
            <th class="text-left cursor-pointer mobile-hide">{{ $t('ruang_nama') }}</th>
            <th class="text-center cursor-pointer mobile-hide">{{ $t('jadwal_label_alokasi') }}</th>
            <th class="text-left cursor-pointer mobile-hide">{{ $t('jadwal_waktu') }}</th>
            <th class="text-left">{{ $t('aksi') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td class="text-center mobile-hide">{{ index + 1 }}</td>
            <td class="text-left mobile-hide">{{ item.lesson_name }}</td>
            <td class="text-left mobile-hide">{{ item.grade_name }}</td>
            <td class="text-left mobile-only cursor-pointer" @click="showDetail(item)">
              {{ item.lesson_name }} - {{ item.grade_name }}
            </td>
            <td class="text-left mobile-hide">{{ item.room_name }}</td>
            <td class="text-center mobile-hide">{{ item.duration }} JP</td>
            <td class="text-left mobile-hide">{{ item.schedule_start }} - {{ item.schedule_end }}</td>
            <td class="text-left">
              <q-btn color="accent" :round="round" icon="fact_check">
                <btn-tooltip :label="$t('absensi_isi_kehadiran')" />
              </q-btn>
            </td>
          </tr>
        </tbody>
      </q-markup-table>
    </q-scroll-area>
    <q-separator/>
    <schedule-detail />
  </div>
</template>

<script>
import { useRouter } from 'vue-router'
import { useStore, mapState } from 'vuex'
import { checkColWidth } from 'src/composables/screen'
import { useQuasar } from 'quasar'
import ScheduleDetail from './ScheduleDetail.vue'

export default {
  name: 'ScheduleItems',
  components: { ScheduleDetail },
  computed: {
    ...mapState('presence', {
      data: state => state.teacherSchedules,
    })
  },
  setup () {
    const store = useStore()
    const router = useRouter()
    const $q = useQuasar()

    return {
      showDetail(detail) {
        store.state.presence.showScheduleDetail = true

        store.state.presence.scheduleDetail = {
          lesson: detail.lesson_name, 
          grade: detail.grade_name, 
          room: detail.room_name,
          duration: detail.duration, 
          start: detail.schedule_start, 
          end: detail.schedule_end
        }
      },
      round: $q.screen.lt.sm ? true : false,
      checkColWidth
    }
  }
}
</script>