<template>
  <div>
    <q-markup-table bordered wrap-cells>
      <thead>
        <tr>
          <th class="text-left mobile-hide">Tanggal Pengajuan</th>
          <th class="text-left mobile-hide">Nama Pegawai</th>
          <th class="text-left mobile-hide">Alasan</th>
          <th class="text-left mobile-hide">Lama Cuti</th>
          <th class="text-left mobile-hide">Mulai</th>
          <th class="text-left mobile-hide">Berakhir</th>
          <th class="text-left">Status</th>
          <th class="text-left">{{ $t('aksi') }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in data" :key="index">
          <td class="text-left mobile-hide">
            {{ $formatDate(item.created, 'DD/MM/YYYY') }}
          </td>
          <td class="text-left mobile-hide">
            {{ item.staff_name }}
          </td>
          <td class="text-left mobile-hide">
            {{ item.reason }}
          </td>
          <td class="text-left mobile-hide">
            {{ item.staff_name }}
          </td>
          <td class="text-left mobile-hide">
            {{ $formatDate(item.start_date, 'DD/MM/YYYY') }}
          </td>
          <td class="text-left mobile-hide">
            {{ $formatDate(item.end_date, 'DD/MM/YYYY') }}
          </td>
          <td class="text-left">
            <status-badge :value="(item.status).toLowerCase()" />
          </td>
          <td class="text-left">
            <q-btn :class="actionButton" class="mobile-only" icon="o_info" @click="getDetail(item.leave_id)">
              <btn-tooltip :label="$t('absensi_label_pr')" />
            </q-btn>
            <q-btn-dropdown class="mobile-hide" text-color="white" split :class="actionButton"
              :label="$t('feedback_label_att')" :href="item.attachment" target="_blank">
              <q-list>
                <q-item clickable v-close-popup @click="setStatus('approved', item.leave_id)">
                  <q-item-section>
                    <q-item-label>{{
                      $t('siabsen_approve_permit')
                    }}</q-item-label>
                  </q-item-section>
                </q-item>
                <q-item clickable v-close-popup @click="setStatus('rejected', item.leave_id)">
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
// import permitType from './permit-type'
import { useSiabsenStore } from 'src/stores/siabsen'
import { usePagingStore } from 'ss-paging-vue'
import { actionButton } from 'src/composables/mode'

const store = useSiabsenStore()
const paging = usePagingStore()
store.getAllLeaveRequest()

// const leaveRequestList = () => store.getAllLeaveRequest()
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