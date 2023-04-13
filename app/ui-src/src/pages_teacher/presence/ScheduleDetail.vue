<template>
  <q-dialog no-backdrop-dismiss 
    v-model="store.showScheduleDetail">
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ $t('guru_detail_jadwal') }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">

        <q-markup-table>
          <tbody>
            <tr><td>{{ $t('absensi_mapel') }}</td><td>: {{ detail.lesson }}</td></tr>
            <tr><td>{{ $t('kelas_nama') }}</td><td>: {{ detail.grade }}</td></tr>
            <tr><td>{{ $t('ruang_nama') }}</td><td>: {{ detail.room }}</td></tr>
            <tr><td>{{ $t('jadwal_label_alokasi') }}</td><td>: {{ detail.duration }} JP</td></tr>
            <tr><td>{{ $t('jadwal_waktu') }}</td><td>: {{ detail.start }} - {{ detail.end }}</td></tr>
          </tbody>
        </q-markup-table>
        
      </q-card-section>
      <q-separator />
      <q-card-actions align="right">
        <q-btn flat :label="$t('tutup')" color="primary" v-close-popup />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { computed } from 'vue'
import { usePresenceStore } from 'src/stores/presence'
import { maximizedDialog, cardDialog } from 'src/composables/screen'

export default {
  name: 'ScheduleDetail',
  setup() {
    const store = usePresenceStore()

    return {
      store,
      maximizedDialog, cardDialog,
      detail: computed(() => store.scheduleDetail),
    }
  }
}
</script>
