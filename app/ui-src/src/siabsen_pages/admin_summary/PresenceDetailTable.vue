<template>
  <div>
    <q-scroll-area class="no-paging-scroll-area" style="margin-top: -10px;">
      <q-markup-table bordered>
        <thead>
          <tr>
            <th class="text-center cursor-pointer mobile-hide">#</th>
            <th class="text-left cursor-pointer">{{ $t('tanggal') }}</th>
            <th class="text-left cursor-pointer">{{ $t('siabsen_in') }}</th>
            <th class="text-left cursor-pointer">{{ $t('siabsen_out') }}</th>
            <th class="text-left cursor-pointer">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in presenceDetail.data" :key="index">
            <td class="text-center mobile-hide">{{ index + 1 }}</td>
            <td class="text-left mobile-hide">{{ $formatDate(item.date) }}</td>
            <td class="text-left mobile-only">{{ $formatDate(item.date, 'DD/MM/YYYY') }}</td>
            <td class="text-left">{{ item.in }}</td>
            <td class="text-left">{{ item.out }}</td>
            <td class="text-left">
              <q-badge :label="item.label" :color="badgeColor(item.status)" />
            </td>
          </tr>
        </tbody>
      </q-markup-table>
    </q-scroll-area>
    <q-separator/>
  </div>
</template>

<script>
import { useStore } from 'vuex'
import { checkColWidth } from 'src/composables/screen'
import { computed } from 'vue'

export default {
  setup () {
    const store = useStore()

    return {
      badgeColor: status => {
        const colors = {
          0: 'negative', 1: 'positive', 2: 'yellow-9'
        }

        return colors[ status ]
      },
      presenceDetail: computed(() => store.state.siabsen.presenceDetail),
      checkColWidth,
    }
  }
}
</script>