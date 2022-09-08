<template>
  <div>
    <q-markup-table bordered>
      <thead>
        <tr>
          <th class="text-left mobile-hide">{{ $t('staff_nama') }}</th>
          <th class="text-left mobile-hide">{{ $t('tanggal') }}</th>
          <th class="text-left mobile-only">
            {{ $t('siabsen_nama_tanggal') }}
          </th>
          <th class="text-left mobile-hide">{{ $t('jadwal_waktu') }}</th>
          <th class="text-left mobile-hide">{{ $t('siabsen_permit_type') }}</th>
          <th class="text-left mobile-hide">{{ $t('siabsen_alasan_izin') }}</th>
          <th class="text-left">Status</th>
          <th class="text-left">{{ $t('aksi') }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in data" :key="index">
          <td class="text-left mobile-hide">{{ $trim(item.staff_name, 20) }}</td>
          <td class="text-left mobile-hide">{{ $formatDate(item.permit_date, 'DD/MM/YYYY') }}</td>
          <td class="text-left mobile-only">
            {{ $trim(item.staff_name, 20) }} <br>
            {{ $formatDate(item.permit_date, 'DD-MMM-YYYY') }}
          </td>
          <td class="text-left mobile-hide">
            {{ trimTime(item.permit_starttime) }} - {{ trimTime(item.permit_endtime) }}
          </td>
          <td class="text-left mobile-hide">{{ permitType(item.permit_presence) }}</td>
          <td class="text-left mobile-hide">{{ $trim(item.permit_reason, 25) }}</td>
          <td class="text-left">
            <status-badge :value="item.permit_status" />
          </td>
          <td class="text-left">
            <q-btn color="accent" class="mobile-only" icon="o_info" @click="getDetail(item.permit_id)">
              <btn-tooltip :label="$t('absensi_label_pr')" />
            </q-btn>
            <q-btn-dropdown
              class="mobile-hide"
              split
              color="accent"
              :label="$t('feedback_label_att')"
              :href="item.permit_photo"
              target="_blank"
            >
              <q-list>
                <q-item clickable v-close-popup @click="setStatus('approved', item.permit_id)">
                  <q-item-section>
                    <q-item-label>{{ $t('siabsen_approve_permit') }}</q-item-label>
                  </q-item-section>
                </q-item>
                <q-item clickable v-close-popup @click="setStatus('rejected', item.permit_id)">
                  <q-item-section>
                    <q-item-label>{{ $t('siabsen_reject_permit') }}</q-item-label>
                  </q-item-section>
                </q-item>
              </q-list>
            </q-btn-dropdown>
          </td>
        </tr>
      </tbody>
    </q-markup-table>
  </div>
</template>

<script>
import { useRouter } from 'vue-router'
import { useStore } from 'vuex'
import { checkColWidth } from 'src/composables/screen'
import { computed } from 'vue'
import StatusBadge from 'src/siabsen_pages/teacher_permit/StatusBadge.vue'
import permitType from './permit-type'

export default {
  components: { StatusBadge },
  setup() {
    const router = useRouter();
    const store = useStore();
    store.dispatch('siabsen/getPermissions');

    return {
      permitType,
      getDetail: id => store.dispatch('siabsen/getPermissionDetail', id),
      trimTime(val) {
        return val === undefined ? '' : val.substring(0, 5)
      },
      setStatus: (val, id ) => {
        store.dispatch('siabsen/setPermitStatus', {
          status: val, 
          id
        })
      },
      data: computed(() => store.state.siabsen.paging.data),
      checkColWidth,
    }
  }  
}
</script>