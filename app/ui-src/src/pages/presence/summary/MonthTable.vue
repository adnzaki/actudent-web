<template>
  <div v-if="store.showMonthTable">
    <q-markup-table separator="cell" class="my-sticky-header-column-table" flat bordered>
      <thead>
        <tr>
          <th class="text-left" rowspan="2">#</th>
          <th class="text-center" rowspan="2">{{ $t('siswa_nama') }}</th>
          <th class="text-center" :colspan="monthlySummary.days.length">{{ $t('tanggal') }}</th>
          <th class="text-center" colspan="4">{{ $t('absensi_ringkasan') }}</th>
        </tr>
        <tr>
          <th class="text-center" v-for="(item, key) in monthlySummary.days" :key="key">
            {{ item }}
          </th> 
          <th class="text-center">H</th>   
          <th class="text-center">I</th>
          <th class="text-center">S</th>
          <th class="text-center">A</th>
        </tr>
      </thead> 
      <tbody>
        <tr v-for="(item, index) in monthlySummary.students" :key="index">
          <td class="text-left">{{ index + 1 }}</td>
          <td class="text-left">{{ item.name }}</td>
          <td class="text-center" v-for="(x, i) in item.data" :key="i">
            <q-icon :name="presenceStatus(x)" />
          </td>
          <td class="text-center">{{ item.summary.present }}</td>
          <td class="text-center">{{ item.summary.permit }}</td>
          <td class="text-center">{{ item.summary.sick }}</td>
          <td class="text-center">{{ item.summary.absent }}</td>
        </tr>
        <tr>
          <td :colspan="monthlySummary.days.length + 6"></td>
        </tr>
      </tbody>
    </q-markup-table>
    <!-- <q-scroll-area class="no-paging-scroll-area">
    </q-scroll-area> -->
    <q-separator/>
  </div>
</template>
<style lang="sass">
.my-sticky-header-column-table
  /* height or max-height is important */
  height: 62vh

  /* specifying max-width so the example can
    highlight the sticky column on any browser window */
  max-width: 100%

  tr th
    position: sticky
    /* higher than z-index for td below */
    z-index: 2
    /* bg color is important; just specify one */
  
  tr th, td:first-child, td:nth-child(2)
    background: #434444
    color: #fff
    border-color: #636363

  /* this will be the loading indicator */
  thead tr:last-child th
    /* height of all previous header rows */
    top: 48px
    /* highest z-index */
    z-index: 3
  thead tr:first-child th
    top: 0
    z-index: 1
  tr:first-child th:first-child, tr:first-child th:first-child,
  tr:first-child 
    /* highest z-index */
    z-index: 5

  td:first-child, th:first-child
    position: sticky
    left: 0

  @media(max-width: 600px)
    td:first-child
      z-index: 4

  @media(min-width: 600px)
    td:nth-child(2), th:nth-child(2)
      left: 40px
      position: sticky
    td:first-child
      position: sticky
      left: 0

    td:first-child, td:nth-child(2)
      z-index: 4

    tr:nth-child(1) th:nth-child(2)
      z-index: 5
</style>

<script>
import { ref, computed } from 'vue'
import { usePresenceStore } from 'src/stores/presence'

export default {
  name: 'MonthTable',
  setup() {
    const store = usePresenceStore()

    return { 
      store,
      showDays: ref(false),
      presenceStatus(id) {
        const icons = {
          0: 'close',
          '1': 'done',
          '2': 'o_info',
          3: 'o_local_hospital'
        }

        return id !== '-' ? icons[ id ] : id
      },
      monthlySummary: computed(() => store.monthlySummary)
    }
  }
}
</script>
