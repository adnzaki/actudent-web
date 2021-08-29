<template>
  <div>
    <q-scroll-area class="no-paging-scroll-area" v-if="member.length > 0">
      <q-markup-table bordered>
        <thead>
          <tr>
            <th :class="['text-left cursor-pointer mobile-hide', checkColWidth()]">#</th>
            <th class="text-left cursor-pointer mobile-hide">{{ $t('siswa_nis') }}</th>
            <th class="text-left cursor-pointer">{{ $t('siswa_nama') }}</th>
            <th class="text-left">{{ $t('aksi') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in member" :key="index">
            <td :class="['text-left mobile-hide', checkColWidth()]">{{ index + 1 }}</td>
            <td class="text-left mobile-hide">{{ item.student_nis }}</td>
            <td class="text-left">{{ item.student_name }}</td>
            <td class="text-left">
            <q-btn color="negative" icon="delete">
              <q-tooltip anchor="top middle" self="center middle" :offset="[10, 10]">
                {{ $t('kelas_hapus_member_title') }}
              </q-tooltip>
            </q-btn>
            </td>
          </tr>
        </tbody>
      </q-markup-table>
    </q-scroll-area>
    <br>
    <p v-if="member.length < 1" class="q-pl-md q-pb-md"><strong>{{ $t('kelas_masih_kosong') }}</strong></p>
  </div>
</template>

<script>
import { useStore, mapState } from 'vuex'
import { checkColWidth } from 'src/composables/screen'

export default {
  name: 'MemberTable',
  created() {
    setTimeout(() => {
      this.$store.commit('grade/getClassMember', this.$route.params.id)  
    }, 500)
  },
  computed: {
    ...mapState('grade', {
      member: state => state.classMember.students,
    })
  },
  setup () {
    const store = useStore()

    return {
      checkColWidth
    }
  }
}
</script>