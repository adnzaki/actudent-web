<template>
  <div>
    <spinner v-if="$store.state.siabsen.spinner" />
    <q-markup-table :separator="separator" flat bordered v-if="!$store.state.siabsen.spinner">
      <thead>
        <tr>
          <th class="text-center" rowspan="2">#</th>
          <th class="text-center mobile-hide" rowspan="2">{{ $t('staff_nama') }}</th>
          <th class="text-center mobile-only" rowspan="2">{{ $t('staff_nama') }} / {{ $t('absensi_ringkasan') }}</th>
          <th class="text-center mobile-hide" colspan="3">{{ $t('absensi_ringkasan') }}</th>
          <th class="text-center" rowspan="2">{{ $t('aksi') }}</th>
        </tr>
        <tr class="mobile-hide">
          <th class="text-center">{{ $t('absensi_hadir') }}</th>   
          <th class="text-center">{{ $t('absensi_izin') }}</th>
          <th class="text-center">{{ $t('absensi_alfa') }}</th>
        </tr>
      </thead> 
      <tbody>
        <tr v-for="(item, index) in summary" :key="index">
          <td class="text-center">{{ $store.getters['siabsen/itemNumber'](index) }}</td>
          <td class="text-left mobile-hide">{{ item.name }}</td>
          <td class="text-left mobile-only">
            {{ item.name }} <br />
            {{ $t('absensi_hadir') }}: <strong>{{ item.present }}</strong> <br />
            {{ $t('absensi_izin') }}: <strong>{{ item.permit }}</strong> <br />
            {{ $t('absensi_alfa') }}: <strong>{{ item.absent }}</strong> <br />
          </td>
          <td class="text-center mobile-hide">{{ item.present }}</td>
          <td class="text-center mobile-hide">{{ item.permit }}</td>
          <td class="text-center mobile-hide">{{ item.absent }}</td>
          <td class="text-center">
            <q-btn-group class="mobile-hide">
              <q-btn color="accent" icon="preview" @click="openDetail(item.id, item.user)" />
              <q-btn color="accent" icon="print" 
                :href="exportPdf(item.id, item.user)" target="_blank" />
            </q-btn-group>
            <q-btn round icon="more_vert" color="accent" class="mobile-only" outline>
              <q-menu>
                <q-list style="min-width: 100px">
                  <q-item clickable v-close-popup @click="openDetail(item.id, item.user)">
                    <q-item-section>{{ $t('tampilkan') }}</q-item-section>
                  </q-item>
                  <q-separator />
                  <q-item clickable v-close-popup 
                    :href="exportPdf(item.id, item.user)" target="_blank">
                    <q-item-section>{{ $t('absensi_print_pdf') }}</q-item-section>
                  </q-item>
                </q-list>
              </q-menu>
            </q-btn>
          </td>
        </tr>
      </tbody>
    </q-markup-table>    
  </div>
</template>
<script>
import { useStore } from 'vuex'
import { computed } from 'vue'
import { useQuasar } from 'quasar'
import { useRouter } from 'vue-router'
import { conf } from 'src/composables/common'

export default {
  setup() {
    const store = useStore()
    const $q = useQuasar()
    const router = useRouter()

    const exportPdf = (id, user) => {
      return `${conf.siabsenAPI}print-rekap-individu/` +
             `${id}/${user}/` + 
             `${store.state.siabsen.dateRangeStart}/${store.state.siabsen.dateRangeEnd}/` +
             `${$q.cookies.get(conf.cookieName)}`
    }
    
    return {
      exportPdf,
      openDetail(staffId, userId) {
        const url = '/teacher-presence/monthly-summary/detail/' +
                    staffId + '/' + userId + '/' + store.state.siabsen.dateRangeStart +
                    '/' + store.state.siabsen.dateRangeEnd
        router.push(url)
      },
      separator: $q.screen.lt.sm ? 'horizontal' : 'cell',
      summary: computed(() => store.state.siabsen.paging.data)
    }
  }
}
</script>
