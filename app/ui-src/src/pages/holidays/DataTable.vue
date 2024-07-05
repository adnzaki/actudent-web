<template>
  <div>
    <q-scroll-area class="table-scroll-area">
      <q-markup-table bordered wrap-cells>
        <thead>
          <tr>
            <th :class="['text-left cursor-pointer', checkColWidth()]">
              <q-checkbox
                v-model="store.checkAll"
                @update:model-value="store.selectAll"
              />
            </th>
            <th class="text-left cursor-pointer">
              {{ $t('libur_col_title') }}
            </th>
            <th
              class="text-left cursor-pointer mobile-hide"
              @click="paging.sortData('start_date')"
            >
              {{ $t('libur_start_date') }} <sort-icon />
            </th>
            <th
              class="text-left cursor-pointer mobile-hide"
              @click="paging.sortData('end_date')"
            >
              {{ $t('libur_end_date') }} <sort-icon />
            </th>
            <th class="text-left">{{ $t('aksi') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td :class="['text-left', checkColWidth()]">
              <q-checkbox v-model="store.selectedDays" :val="item.holiday_id" />
            </td>
            <td class="text-left mobile-hide">{{ item.holiday_title }}</td>
            <td class="text-left mobile-only">
              <strong>{{ item.holiday_title }} </strong><br />{{
                item.start_date_short
              }}
              -
              {{ item.end_date_short }}
            </td>
            <td class="text-left mobile-hide">{{ item.start_date }}</td>
            <td class="text-left mobile-hide">{{ item.end_date }}</td>
            <td class="text-left">
              <q-btn-group class="mobile-hide">
                <q-btn
                  :class="actionButton"
                  icon="edit"
                  @click="store.getDetail(item.holiday_id)"
                />
                <q-btn
                  :class="actionButton"
                  icon="delete"
                  @click="store.showDeleteConfirm(item.holiday_id)"
                />
              </q-btn-group>
              <q-btn round icon="more_vert" class="mobile-only" unelevated flat>
                <q-menu>
                  <q-list style="min-width: 100px">
                    <q-item
                      clickable
                      v-close-popup
                      @click="store.getDetail(item.holiday_id)"
                    >
                      <q-item-section>{{ $t('perbarui') }}</q-item-section>
                    </q-item>
                    <q-separator />
                    <q-item
                      clickable
                      v-close-popup
                      @click="store.showDeleteConfirm(item.room_id)"
                    >
                      <q-item-section>{{ $t('hapus') }}</q-item-section>
                    </q-item>
                  </q-list>
                </q-menu>
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

<script setup>
import { watch, computed } from 'vue'
import { checkColWidth } from 'src/composables/screen'
import { useHolidaysStore } from 'src/stores/holidays'
import { usePagingStore } from 'ss-paging-vue'
import { actionButton } from 'src/composables/mode'

const store = useHolidaysStore()
const paging = usePagingStore()
const data = computed(() => paging.state.data)

store.getHolidays()

watch(data, () => {
  store.checkAll = false
  store.selectedDays = []
})
</script>
