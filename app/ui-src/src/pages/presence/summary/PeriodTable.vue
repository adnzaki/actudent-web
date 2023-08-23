<template>
  <div v-if="store.showPeriodTable">
    <q-scroll-area class="no-paging-scroll-area">
      <q-markup-table separator="cell" flat bordered wrap-cells>
        <thead>
          <tr>
            <th class="text-center" rowspan="2">#</th>
            <th class="text-center mobile-hide" rowspan="2">
              {{ $t('siswa_nama') }}
            </th>
            <th class="text-center mobile-only" rowspan="2">
              {{ $t('absensi_ringkasan') }}
            </th>
            <th class="text-center mobile-hide" colspan="5">
              {{ $t('absensi_ringkasan') }}
            </th>
          </tr>
          <tr>
            <th class="text-center mobile-hide">{{ $t('absensi_hadir') }}</th>
            <th class="text-center mobile-hide">{{ $t('absensi_izin') }}</th>
            <th class="text-center mobile-hide">{{ $t('absensi_sakit') }}</th>
            <th class="text-center mobile-hide">{{ $t('absensi_alfa') }}</th>
            <th class="text-center mobile-hide">
              {{ $t('absensi_incomplete') }}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in periodSummary.summary" :key="index">
            <td class="text-center">{{ index + 1 }}</td>
            <td class="text-left mobile-hide">{{ item.name }}</td>
            <td class="text-left mobile-only">
              <q-list bordered separator>
                <q-item>
                  <q-item-section>
                    <q-item-label
                      ><strong>{{ item.name }}</strong></q-item-label
                    >
                  </q-item-section>
                </q-item>
                <q-item>
                  <q-item-section>
                    <q-item-label caption>{{
                      $t('absensi_hadir')
                    }}</q-item-label>
                    <q-item-label>{{ item.present }}</q-item-label>
                  </q-item-section>
                </q-item>
                <q-item>
                  <q-item-section>
                    <q-item-label caption>{{
                      $t('absensi_izin')
                    }}</q-item-label>
                    <q-item-label>{{ item.permit }}</q-item-label>
                  </q-item-section>
                </q-item>
                <q-item>
                  <q-item-section>
                    <q-item-label caption>{{
                      $t('absensi_sakit')
                    }}</q-item-label>
                    <q-item-label>{{ item.sick }}</q-item-label>
                  </q-item-section>
                </q-item>
                <q-item>
                  <q-item-section>
                    <q-item-label caption>{{
                      $t('absensi_alfa')
                    }}</q-item-label>
                    <q-item-label>{{ item.absent }}</q-item-label>
                  </q-item-section>
                </q-item>
              </q-list>
            </td>
            <td class="text-center mobile-hide">{{ item.present }}</td>
            <td class="text-center mobile-hide">{{ item.permit }}</td>
            <td class="text-center mobile-hide">{{ item.sick }}</td>
            <td class="text-center mobile-hide">{{ item.absent }}</td>
            <td class="text-center mobile-hide">{{ item.incomplete }}</td>
          </tr>
        </tbody>
      </q-markup-table>
    </q-scroll-area>
    <q-separator />
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
      store,
      periodSummary: computed(() => store.periodSummary),
    }
  },
}
</script>
