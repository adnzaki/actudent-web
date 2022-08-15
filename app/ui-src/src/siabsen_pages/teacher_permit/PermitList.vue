<template>
  <div>
    <q-scroll-area class="table-scroll-area">
      <q-markup-table bordered>
        <thead>
          <tr>
            <th class="text-center">#</th>
            <th class="text-left">{{ $t('tanggal') }}</th>
            <th class="text-left mobile-hide">{{ $t('jadwal_waktu') }}</th>
            <th class="text-left mobile-hide">{{ $t('siabsen_alasan_izin') }}</th>
            <th class="text-left mobile-hide">{{ $t('siabsen_permit_type') }}</th>
            <th class="text-left">Status</th>
            <th class="text-left mobile-hide">{{ $t('feedback_label_att') }}</th>
            <th class="text-left mobile-only">{{ $t('aksi') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td class="text-center">{{ $store.getters['siabsen/itemNumber'](index) }}</td>
            <td class="text-left" v-if="$q.screen.lt.sm">{{ $formatDate(item.permit_date, 'DD/MM/YYYY') }}</td>
            <td class="text-left" v-else>{{ $formatDate(item.permit_date, 'dddd, DD-MMM-YYYY') }}</td>
            <td class="text-left mobile-hide">
              {{ item.permit_starttime.substring(0, 5) }} - {{ item.permit_endtime.substring(0, 5) }}
            </td>
            <td class="text-left mobile-hide">{{ $trim(item.permit_reason) }}</td>
            <td class="text-left mobile-hide">{{ permitType(item.permit_presence) }}</td>
            <td class="text-left">
              <status-badge :value="item.permit_status" />
            </td>
            <td class="text-left mobile-hide">
              <q-btn-group>
                <q-btn target="_blank" color="accent" icon="image" :href="item.permit_photo">
                  <btn-tooltip :label="$t('feedback_label_att')" />
                </q-btn>
                <q-btn color="accent" :disable="item.permit_status !== 'submitted'" 
                  icon="delete" @click="showDeleteConfirm(item.permit_id)">
                  <btn-tooltip :label="$t('hapus')" />
                </q-btn>
              </q-btn-group>
            </td>
            <td class="text-left mobile-only">
              <q-btn round icon="more_vert" color="accent" class="mobile-only" outline>
                <q-menu>
                  <q-list style="min-width: 100px">
                    <q-item clickable v-close-popup @click="getDetail(item.permit_id)">
                      <q-item-section>{{ $t('siabsen_detail_izin') }}</q-item-section>
                    </q-item>
                    <q-separator />
                    <q-item clickable v-close-popup 
                      :disable="item.permit_status !== 'submitted'" 
                      @click="showDeleteConfirm(item.permit_id)">
                      <q-item-section>{{ $t('hapus') }}</q-item-section>
                    </q-item>
                    <q-separator />
                  </q-list>
                </q-menu>
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
import permitType from '../admin_permit/permit-type'

export default {
  components: { StatusBadge },
  setup() {
    const router = useRouter();
    const store = useStore();
    store.dispatch('siabsen/getPermissions')

    return {
      permitType,
      showDeleteConfirm(id) {
        store.dispatch('siabsen/showDeleteConfirm', id)
      },
      getDetail: id => store.dispatch('siabsen/getPermissionDetail', id),
      data: computed(() => store.state.siabsen.paging.data),
      checkColWidth,
    }
  }  
}
</script>