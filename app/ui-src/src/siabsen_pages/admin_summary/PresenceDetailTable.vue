<template>
  <div class="mobile-hide">
    <q-markup-table bordered style="margin-top: -10px;">
      <thead>
        <tr>
          <th class="text-center cursor-pointer">#</th>
          <th class="text-left cursor-pointer">{{ $t('tanggal') }}</th>
          <th class="text-left cursor-pointer">{{ $t('siabsen_in') }}</th>
          <th class="text-left cursor-pointer">{{ $t('siabsen_out') }}</th>
          <th class="text-left cursor-pointer">{{ $t('siabsen_terlambat') }}</th>
          <th class="text-left cursor-pointer">{{ $t('siabsen_worktime') }}</th>
          <th class="text-left cursor-pointer">{{ $t('siabsen_overtime') }}</th>
          <th class="text-left cursor-pointer">Status</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in presenceDetail.data" :key="index">
          <td class="text-center">{{ index + 1 }}</td>
          <td class="text-left">{{ $formatDate(item.date) }}</td>
          <td class="text-left">
            <q-chip size="sm" :color="chipColor(item.status)" text-color="white">
              <strong style="font-size: 12px" v-if="item.in !== '-'">{{ item.in }}</strong>
              <strong style="font-size: 12px" v-else>--:--</strong>
            </q-chip>  
          </td>
          <td class="text-left">
            <q-chip size="sm" :color="chipColor(item.status)" text-color="white">
              <strong style="font-size: 12px" v-if="item.out !== '-'">{{ item.out }}</strong>
              <strong style="font-size: 12px" v-else>--:--</strong>
            </q-chip> 
          </td>
          <td class="text-left">{{ item.late }}</td>
          <td class="text-left">{{ item.work }}</td>
          <td class="text-left">{{ item.over }}</td>
          <td class="text-left">
            <q-badge v-if="item.label !== '-'" :label="item.label" :color="badgeColor(item.status)" />
            <div v-else>{{ item.label }}</div>
          </td>
        </tr>        
      </tbody>
    </q-markup-table>
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
      chipColor: status => {
        const colors = {
          'alfa': 'negative', 'hadir': 'positive', 'izin': 'blue'
        }

        return colors[ status ]
      },
      badgeColor: status => {
        const colors = {
          'alfa': 'negative', 'hadir': 'positive', 'izin': 'blue'
        }

        return colors[ status ]
      },
      presenceDetail: computed(() => store.state.siabsen.presenceDetail),
      checkColWidth,
    }
  }
}
</script>