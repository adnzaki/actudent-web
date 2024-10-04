<template>
  <div>
    <q-markup-table bordered wrap-cells>
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
          <td class="text-left mobile-hide">
            {{ item.staff_name }}
          </td>
          <td class="text-left mobile-hide">
            {{ $formatDate(item.permit_date, 'DD/MM/YYYY') }}
          </td>
          <td class="text-left mobile-only">
            {{ item.staff_name }} <br />
            {{ $formatDate(item.permit_date, 'DD-MMM-YYYY') }}
          </td>
          <td class="text-left mobile-hide">
            {{ trimTime(item.permit_starttime) }} -
            {{ trimTime(item.permit_endtime) }}
          </td>
          <td class="text-left mobile-hide">
            {{ permitType(item.permit_type) }} - <br />{{
              permitPresence(item.permit_presence)
            }}
          </td>
          <td class="text-left mobile-hide">
            {{ item.permit_reason }}
          </td>
          <td class="text-left">
            <status-badge :value="item.permit_status" />
          </td>
          <td class="text-left">
            <q-btn
              :class="actionButton"
              class="mobile-only"
              icon="o_info"
              @click="getDetail(item.permit_id)"
            >
              <btn-tooltip :label="$t('absensi_label_pr')" />
            </q-btn>
            <q-btn-dropdown
              class="mobile-hide"
              text-color="white"
              split
              :class="actionButton"
              :label="$t('feedback_label_att')"
              :href="item.permit_photo"
              target="_blank"
            >
              <q-list>
                <q-item
                  clickable
                  v-close-popup
                  @click="setStatus('approved', item.permit_id)"
                >
                  <q-item-section>
                    <q-item-label>{{
                      $t('siabsen_approve_permit')
                    }}</q-item-label>
                  </q-item-section>
                </q-item>
                <q-item
                  clickable
                  v-close-popup
                  @click="setStatus('rejected', item.permit_id)"
                >
                  <q-item-section>
                    <q-item-label>{{
                      $t('siabsen_reject_permit')
                    }}</q-item-label>
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

<script setup>
import { checkColWidth } from 'src/composables/screen'
import { computed } from 'vue'
import StatusBadge from 'src/siabsen_pages/teacher_permit/StatusBadge.vue'
import { permitType, permitPresence } from './permit-type'
import { useSiabsenStore } from 'src/stores/siabsen'
import { usePagingStore } from 'ss-paging-vue'
import { actionButton } from 'src/composables/mode'

const store = useSiabsenStore()
const paging = usePagingStore()
store.getPermissions()

const getDetail = (id) => store.getPermissionDetail(id)
const trimTime = (val) => {
  return val === undefined ? '' : val.substring(0, 5)
}
const setStatus = (val, id) => {
  store.setPermitStatus({
    status: val,
    id,
  })
}
const data = computed(() => paging.state.data)
</script>
