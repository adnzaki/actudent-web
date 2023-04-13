<template>
  <div v-if="store.showPeriodTable">
    <q-scroll-area class="no-paging-scroll-area">
      <q-markup-table separator="cell" flat bordered>
        <thead>
          <tr>
            <th class="text-center" rowspan="2">#</th>
            <th class="text-center" rowspan="2">{{ $t('siswa_nama') }}</th>
            <th class="text-center" colspan="5">{{ $t('absensi_ringkasan') }}</th>
          </tr>
          <tr>
            <th class="text-center">{{ $t('absensi_hadir') }}</th>   
            <th class="text-center">{{ $t('absensi_izin') }}</th>
            <th class="text-center">{{ $t('absensi_sakit') }}</th>
            <th class="text-center">{{ $t('absensi_alfa') }}</th>
            <th class="text-center">{{ $t('absensi_incomplete') }}</th>
          </tr>
        </thead> 
        <tbody>
          <tr v-for="(item, index) in periodSummary.summary" :key="index">
            <td class="text-center">{{ index + 1 }}</td>
            <td class="text-left">{{ item.name }}</td>
            <td class="text-center">{{ item.present }}</td>
            <td class="text-center">{{ item.permit }}</td>
            <td class="text-center">{{ item.sick }}</td>
            <td class="text-center">{{ item.absent }}</td>
            <td class="text-center">{{ item.incomplete }}</td>
          </tr>
        </tbody>
      </q-markup-table>
    </q-scroll-area>
    <q-separator/>
  </div>
</template>
<script>
import { computed, onUnmounted } from 'vue'
import { usePresenceStore } from 'src/stores/presence'

export default {
  name: 'PeriodTable',
  setup() {
    const store = usePresenceStore()

    onUnmounted(() => {
      store.showPeriodTable = false
    })

    return {
      periodSummary: computed(() => store.periodSummary)
    }
  }
}
</script>
