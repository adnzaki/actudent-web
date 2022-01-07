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
            <td class="text-center">{{ $store.getters['grade/itemNumber'](index) }}</td>
            <td class="text-left">{{ item.grade_name }}</td>
            <td class="text-left mobile-hide">{{ item.staff_name }}</td>
            <td class="text-left mobile-hide">{{ item.period_start }} / {{ item.period_end }}</td>
            <td class="text-left">
              <q-btn color="accent" icon="article" @click="fillPresence(item.grade_id, item.grade_name)">
                <q-tooltip anchor="top middle" self="bottom middle" :offset="[10, 10]">
                  {{ $t('absensi_isi_kehadiran') }}
                </q-tooltip>
              </q-btn>
            </td>
          </tr>
        </tbody>
      </q-markup-table>
    </q-scroll-area>
    <q-separator/>
    <ss-paging vuex-module="grade" />
  </div>
</template>

<script>
import { useRouter } from 'vue-router'
import { useStore, mapState, mapActions } from 'vuex'
import { checkColWidth } from 'src/composables/screen'

export default {
  name: 'ClassTable',
  methods: {
    ...mapActions('grade', [
      'sortData'
    ]),
  },
  computed: {
    ...mapState('grade', {
      data: state => state.paging.data,
    })
  },
  setup () {
    const store = useStore()
    const router = useRouter()

    setTimeout(() => {
      store.dispatch('grade/getClassList')  
    }, 500)

    const fillPresence = (id, name) => {
      // store.state.grade.classMember.name = name
      // router.push(`/class/member/${id}`)
    }

    return {
      checkColWidth,
      fillPresence
    }
  }
}
</script>