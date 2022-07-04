<template>
  <div>
    <q-scroll-area class="no-paging-scroll-area" style="margin-top: -10px;">
      <q-markup-table bordered>
        <thead>
          <tr>
            <th class="text-center cursor-pointer mobile-hide">#</th>
            <th class="text-left cursor-pointer mobile-hide">{{ $t('tanggal') }}</th>
            <th class="text-left cursor-pointer mobile-only">
              {{ $t('tanggal') }} /<br />{{ $t('siabsen_in') }} /<br />{{ $t('siabsen_out') }}
            </th>
            <th class="text-left cursor-pointer mobile-hide">{{ $t('siabsen_in') }}</th>
            <th class="text-left cursor-pointer mobile-hide">{{ $t('siabsen_out') }}</th>
            <th class="text-left cursor-pointer">{{ $t('siabsen_terlambat') }}</th>
            <th class="text-left cursor-pointer">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in presenceDetail.data" :key="index">
            <td class="text-center mobile-hide">{{ index + 1 }}</td>
            <td class="text-left mobile-hide">{{ $formatDate(item.date) }}</td>
            <td class="text-left mobile-only">
              <strong>{{ $formatDate(item.date, 'DD-MMM') }}</strong> <br />
              {{ item.in }} <br />{{ item.out }}
            </td>
            <td class="text-left mobile-hide">{{ item.in }}</td>
            <td class="text-left mobile-hide">{{ item.out }}</td>
            <td class="text-left">{{ item.late }}</td>
            <td class="text-left">
              <q-badge v-if="item.label !== '-'" :label="item.label" :color="badgeColor(item.status)" />
              <div v-else>{{ item.label }}</div>
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