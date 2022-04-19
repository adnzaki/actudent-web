<template>
  <div>
    <q-scroll-area class="table-scroll-area">
      <q-markup-table bordered>
        <thead>
          <tr>
            <th class="text-center cursor-pointer">#</th>
            <th class="text-left cursor-pointer" @click="sortData('grade_name')">{{ $t('kelas_nama') }} <sort-icon /></th>
            <th class="text-left cursor-pointer mobile-hide" @click="sortData('staff_name')">{{ $t('kelas_wali') }} <sort-icon /></th>
            <th class="text-left cursor-pointer mobile-hide">{{ $t('kelas_tahun') }}</th>
            <th class="text-left">{{ $t('aksi') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td class="text-center">{{ $store.getters['schedule/itemNumber'](index) }}</td>
            <td class="text-left mobile-hide">{{ item.grade_name }}</td>
            <td class="text-left mobile-only">{{ $trim(item.grade_name, 30) }}</td>
            <td class="text-left mobile-hide">{{ item.staff_name }}</td>
            <td class="text-left mobile-hide">{{ item.period_start }} / {{ item.period_end }}</td>
            <td class="text-left">
              <q-btn-group class="mobile-hide">
                <q-btn color="accent" icon="list" @click="showLessons(item.grade_id, item.grade_name)" />
                <q-btn color="accent" icon="menu_book" @click="showSchedules(item.grade_id, item.grade_name)" />
              </q-btn-group>
              <q-btn round icon="more_vert" color="accent" class="mobile-only" outline>
                <q-menu>
                  <q-list style="min-width: 200px">
                    <q-item clickable v-close-popup @click="showLessons(item.grade_id, item.grade_name)">
                      <q-item-section>{{ $t('jadwal_daftar_mapel') }}</q-item-section>
                    </q-item>
                    <q-separator />
                    <q-item clickable v-close-popup @click="showSchedules(item.grade_id, item.grade_name)">
                      <q-item-section>{{ $t('jadwal_jadwal_mapel') }}</q-item-section>
                    </q-item>
                    <q-separator />
                  </q-list>
                </q-menu>
              </q-btn>
            </td>
          </tr>
        </tbody>
      </q-markup-table>
    </q-scroll-area>
    <q-separator/>
    <ss-paging vuex-module="schedule" />
  </div>
</template>

<script>
import { useRouter } from 'vue-router'
import { useStore, mapState, mapActions } from 'vuex'
import { checkColWidth } from 'src/composables/screen'

export default {
  name: 'ClassList',
  created() {
    setTimeout(() => {
      this.$store.dispatch('schedule/getClassList')  
    }, 500)
  },
  methods: {
    ...mapActions('schedule', [
      'sortData'
    ]),
  },
  computed: {
    ...mapState('schedule', {
      data: state => state.paging.data,
    })
  },
  setup () {
    const router = useRouter()
    const store = useStore()

    const showLessons = (gradeId, name) => {      
      store.state.schedule.className = name
      router.push(`/schedules/lessons/${gradeId}`)
    }

    const showSchedules = (gradeId, name) => {      
      store.state.schedule.className = name
      router.push(`/schedules/mapping/${gradeId}`)
    }

    return {
      checkColWidth,
      showLessons,
      showSchedules
    }
  }
}
</script>