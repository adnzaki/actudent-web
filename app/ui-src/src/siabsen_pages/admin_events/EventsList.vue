<template>
  <div>
    <q-scroll-area class="no-paging-scroll-area">
      <q-markup-table bordered>
        <thead>
          <tr>
            <th class="text-center cursor-pointer">#</th>
            <th class="text-left">{{ $t('tanggal') }}</th>
            <th class="text-left">{{ $t('agenda_label_nama') }}</th>
            <th class="text-left">{{ $t('jadwal_waktu') }}</th>
            <th class="text-left">{{ $t('aksi') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in allEvents" :key="index">
            <td class="text-center">{{ index + 1 }}</td>
            <td class="text-left">{{ item.date }}</td>
            <td class="text-left">{{ item.name }}</td>
            <td class="text-left">{{ item.time }}</td>
            <td class="text-left">
              <q-btn color="accent" icon="assignment_ind"
                @click="goToAttendance(item.id)">
                <btn-tooltip :label="$t('siabsen_event_attendance')" />
              </q-btn>
            </td>
          </tr>
        </tbody>
      </q-markup-table>
    </q-scroll-area>
    <q-separator/>
  </div>
</template>

<script>
import { computed, inject } from 'vue'
import { useStore } from 'vuex'
import { useQuasar } from 'quasar'


export default {
  setup () {
    const store = useStore()
    const $q = useQuasar()
    const goToAttendance = inject('goToAttendance')

    return {
      goToAttendance,
      allEvents: computed(() => store.state.siabsen.allEvents),
    }
  }
}
</script>