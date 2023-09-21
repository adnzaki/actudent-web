<template>
  <div>
    <staff-list-mobile v-if="$q.screen.lt.md" />
    <q-scroll-area class="table-scroll-area" v-else>
      <q-markup-table bordered>
        <thead>
          <tr>
            <th class="text-center cursor-pointer">#</th>
            <th class="text-left cursor-pointer">{{ $t('staff_id') }}</th>
            <th class="text-left cursor-pointer">{{ $t('staff_nama') }}</th>
            <th class="text-left cursor-pointer">{{ $t('siabsen_in') }}</th>
            <th class="text-left cursor-pointer">{{ $t('siabsen_out') }}</th>
            <th class="text-left cursor-pointer">
              {{ $t('siabsen_worktime') }}
            </th>
            <th class="text-left cursor-pointer">
              {{ $t('siabsen_overtime') }}
            </th>
            <th class="text-left">{{ $t('aksi') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td class="text-center">{{ paging.itemNumber(index) }}</td>
            <td class="text-left">{{ item.nip }}</td>
            <td class="text-left">{{ item.name }}</td>
            <td class="text-left">
              {{ item.in }} <br />
              <small class="text-negative" v-if="item.late !== '-'"
                >(+{{ item.late }})</small
              >
            </td>
            <td class="text-left">{{ item.out }}</td>
            <td class="text-left">{{ item.workTime }}</td>
            <td class="text-left">{{ item.overtime }}</td>
            <td class="text-left">
              <q-btn
                :class="addButton"
                :disable="disableBtn(item.in, item.out)"
                icon="image"
                @click="showImage(item.inPhoto, item.outPhoto)"
              >
                <btn-tooltip :label="$t('siabsen_detail_absensi')" />
              </q-btn>
            </td>
          </tr>
        </tbody>
      </q-markup-table>
    </q-scroll-area>
    <q-separator />
    <ss-paging v-model="store.current" />
  </div>
</template>

<script>
import { useRouter } from 'vue-router'
import { useSiabsenStore } from 'src/stores/siabsen'
import { usePagingStore } from 'ss-paging-vue'
import { checkColWidth } from 'src/composables/screen'
import { computed } from 'vue'
import StaffListMobile from './StaffListMobile.vue'
import { addButton } from 'src/composables/mode'

export default {
  name: 'StaffList',
  components: { StaffListMobile },
  setup() {
    const router = useRouter()
    const store = useSiabsenStore()
    const paging = usePagingStore()

    return {
      store,
      paging,
      addButton,
      disableBtn(inPhoto, outPhoto) {
        return inPhoto === '-' && outPhoto === '-' ? true : false
      },
      showImage(inPhoto, outPhoto) {
        store.inPhotoURL = inPhoto
        store.outPhotoURL = outPhoto
        store.showPresenceDetail = true
      },
      data: computed(() => paging.state.data),
      checkColWidth,
    }
  },
}
</script>
