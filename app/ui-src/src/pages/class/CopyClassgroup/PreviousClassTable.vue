<template>
  <div>
    <q-scroll-area class="table-scroll-area">
      <q-markup-table bordered wrap-cells>
        <thead>
          <tr>
            <th :class="['text-left cursor-pointer', checkColWidth()]">
              <q-checkbox
                v-model="store.checkAll"
                @update:model-value="store.selectAll()"
              />
            </th>
            <th
              class="text-left cursor-pointer"
              @click="sortData('grade_name')"
            >
              {{ $t('kelas_nama') }} <sort-icon />
            </th>
            <th
              class="text-left cursor-pointer mobile-hide"
              @click="sortData('staff_name')"
            >
              {{ $t('kelas_wali') }} <sort-icon />
            </th>
            <th class="text-left cursor-pointer mobile-hide">
              {{ $t('kelas_tahun') }}
            </th>
            <th class="text-left">{{ $t('aksi') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td :class="['text-left', checkColWidth()]">
              <q-checkbox
                v-model="store.selectedClasses"
                :val="item.grade_id"
              />
            </td>
            <td class="text-left mobile-hide">{{ item.grade_name }}</td>
            <td class="text-left mobile-only">
              {{ item.grade_name }}<br />
              <small class="text-grey-8">{{ item.staff_name }}</small>
            </td>
            <td class="text-left mobile-hide">{{ item.staff_name }}</td>
            <td class="text-left mobile-hide">
              {{ item.period_start }} / {{ item.period_end }}
            </td>
            <td class="text-left">
              <q-btn
                :class="actionButton"
                icon="add"
                @click="selectClass(item.grade_id)"
              >
                <btn-tooltip :label="$t('kelas_apply_copy')"
              /></q-btn>
            </td>
          </tr>
        </tbody>
      </q-markup-table>
    </q-scroll-area>
    <q-separator />
    <ss-paging v-model="store.current" />
  </div>
</template>

<script setup>
import { watch, computed } from 'vue'
import { usePagingStore } from 'ss-paging-vue'
import { useClassStore } from 'src/stores/class'
import { checkColWidth } from 'src/composables/screen'
import { actionButton } from 'src/composables/mode'

const store = useClassStore()
const paging = usePagingStore()
const pagingData = computed(() => paging.state.data)

watch(pagingData, () => {
  store.checkAll = false
  store.selectedClasses = []
})

const selectClass = (id) => {
  store.selectedClasses = []
  store.selectedClasses.push(id)
  store.confirmCopyClass()
}

const data = pagingData

store.getPreviousClass()
</script>
