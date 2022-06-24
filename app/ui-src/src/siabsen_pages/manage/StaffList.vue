<template>
  <div>
    <q-scroll-area class="table-scroll-area">
      <q-markup-table bordered>
        <thead>
          <tr>
            <th class="text-center cursor-pointer">#</th>
            <th class="text-left cursor-pointer mobile-hide">{{ $t('staff_id') }}</th>
            <th class="text-left cursor-pointer">{{ $t('staff_nama') }}</th>
            <th class="text-left cursor-pointer mobile-hide">{{ $t('siabsen_in') }}</th>
            <th class="text-left cursor-pointer mobile-hide">{{ $t('siabsen_out') }}</th>
            <th class="text-left">{{ $t('aksi') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td class="text-center">{{ $store.getters['siabsen/itemNumber'](index) }}</td>
            <td class="text-left mobile-hide">{{ item.nip }}</td>
            <td class="text-left mobile-only">
              {{ $trim(item.name, 30) }} <br>
              {{ $t('siabsen_in') }}: <b>{{ item.in }}</b> {{ item.late }}<br>
              {{ $t('siabsen_out') }}: <b>{{ item.out }}</b>
            </td>
            <td class="text-left mobile-hide">{{ item.name }}</td>
            <td class="text-left mobile-hide">{{ item.in }} {{ item.late }}</td>
            <td class="text-left mobile-hide">{{ item.out }}</td>
            <td class="text-left">
              <q-btn color="accent" 
                :disable="disableBtn(item.in, item.out)" icon="image"
                @click="showImage(item.inPhoto, item.outPhoto)">
                <btn-tooltip :label="$t('siabsen_detail_absensi')" />
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

export default {
  name: 'StaffList',
  setup () {
    const router = useRouter()
    const store = useStore()

    return {
      disableBtn(inPhoto, outPhoto) {
        return inPhoto === '-' && outPhoto === '-' ? true : false
      },
      showImage(inPhoto, outPhoto) {
        store.state.siabsen.inPhotoURL = inPhoto
        store.state.siabsen.outPhotoURL = outPhoto
        store.state.siabsen.showPresenceDetail = true
      },
      data: computed(() => store.state.siabsen.paging.data),
      checkColWidth,
    }
  }
}
</script>