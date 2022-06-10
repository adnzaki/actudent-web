<template>
  <div>
    <q-scroll-area class="table-scroll-area">
      <q-markup-table bordered>
        <thead>
          <tr>
            <th class="text-center cursor-pointer">#</th>
            <th class="text-left cursor-pointer">{{ $t('tanggal') }}</th>
            <th class="text-left cursor-pointer">{{ $t('jadwal_waktu') }}</th>
            <th class="text-left cursor-pointer">{{ $t('siabsen_alasan_izin') }}</th>
            <th class="text-left">Status</th>
            <th class="text-left cursor-pointer">{{ $t('feedback_label_att') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td class="text-center">{{ $store.getters['siabsen/itemNumber'](index) }}</td>
            <td class="text-left">{{ $formatDate(item.permit_date) }}</td>
            <td class="text-left">
              {{ item.permit_starttime.substring(0, 5) }} - {{ item.permit_endtime.substring(0, 5) }}
            </td>
            <td class="text-left">{{ item.permit_reason }}</td>
            <td class="text-left">
              <status-badge :value="item.permit_status" />
            </td>
            <td class="text-left">
              <q-btn target="_blank" color="accent" icon="image" :href="item.permit_photo">
                <btn-tooltip :label="$t('feedback_label_att')" />
              </q-btn>
            </td>
          </tr>
        </tbody>
      </q-markup-table>
    </q-scroll-area>
    <q-separator/>
    <ss-paging vuex-module="siabsen" />
  </div>
</template>

<script>
import { useRouter } from 'vue-router'
import { useStore } from 'vuex'
import { checkColWidth } from 'src/composables/screen'
import { computed } from 'vue'
import StatusBadge from './StatusBadge.vue'

export default {
  components: { StatusBadge },
  setup() {
    const router = useRouter();
    const store = useStore();
    store.dispatch("siabsen/getPermissions");
    return {
      data: computed(() => store.state.siabsen.paging.data),
      checkColWidth,
    }
  }  
}
</script>