<template>
  <div>
    <q-scroll-area class="table-scroll-area">
      <q-markup-table separator="cell" flat bordered>
        <thead>
          <tr>
            <th class="text-center" rowspan="2">#</th>
            <th class="text-center" rowspan="2">{{ $t('staff_nama') }}</th>
            <th class="text-center" colspan="3">{{ $t('absensi_ringkasan') }}</th>
          </tr>
          <tr>
            <th class="text-center">{{ $t('absensi_hadir') }}</th>   
            <th class="text-center">{{ $t('absensi_izin') }}</th>
            <th class="text-center">{{ $t('absensi_alfa') }}</th>
          </tr>
        </thead> 
        <tbody>
          <tr v-for="(item, index) in summary" :key="index">
            <td class="text-center">{{ index + 1 }}</td>
            <td class="text-left">{{ item.name }}</td>
            <td class="text-center">{{ item.present }}</td>
            <td class="text-center">{{ item.permit }}</td>
            <td class="text-center">{{ item.absent }}</td>
          </tr>
        </tbody>
      </q-markup-table>
    </q-scroll-area>
    <q-separator/>
    <ss-paging vuex-module="siabsen" />
  </div>
</template>
<script>
import { useStore } from 'vuex'
import { computed } from 'vue'

export default {
  setup() {
    const store = useStore()
    
    return {
      summary: computed(() => store.state.siabsen.paging.data)
    }
  }
}
</script>
