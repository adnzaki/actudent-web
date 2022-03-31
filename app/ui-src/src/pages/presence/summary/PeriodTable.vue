<template>
  <div v-if="$store.state.presence.showPeriodTable">
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
import { mapState } from 'vuex'
export default {
  name: 'PeriodTable',
  computed: {
    ...mapState('presence', {
      periodSummary: state => state.periodSummary
    })
  },
}
</script>
