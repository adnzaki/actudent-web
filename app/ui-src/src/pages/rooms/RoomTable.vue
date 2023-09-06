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
            <th
              class="text-left cursor-pointer mobile-hide"
              @click="paging.sortData('room_code')"
            >
              {{ $t('ruang_kode') }} <sort-icon />
            </th>
            <th
              class="text-left cursor-pointer"
              @click="paging.sortData('room_name')"
            >
              {{ $t('ruang_nama') }} <sort-icon />
            </th>
            <th class="text-left">{{ $t('aksi') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td :class="['text-left', checkColWidth()]">
              <q-checkbox v-model="store.selectedRooms" :val="item.room_id" />
            </td>
            <td class="text-left mobile-hide">{{ item.room_code }}</td>
            <td class="text-left">{{ item.room_name }}</td>
            <td class="text-left">
              <q-btn-group class="mobile-hide">
                <q-btn
                  :class="actionButton"
                  icon="edit"
                  @click="store.getDetail(item.room_id)"
                />
                <q-btn
                  :class="actionButton"
                  icon="delete"
                  @click="store.showDeleteConfirm(item.room_id)"
                />
              </q-btn-group>
              <q-btn round icon="more_vert" class="mobile-only" unelevated flat>
                <q-menu>
                  <q-list style="min-width: 100px">
                    <q-item
                      clickable
                      v-close-popup
                      @click="store.getDetail(item.room_id)"
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

<script>
import { watch, computed, defineComponent } from 'vue'
import { checkColWidth } from 'src/composables/screen'
import { useRoomStore } from 'src/stores/room'
import { usePagingStore } from 'ss-paging-vue'
import { actionButton } from 'src/composables/mode'

export default defineComponent({
  name: 'RoomTable',
  setup() {
    const store = useRoomStore()
    const paging = usePagingStore()
    const pagingData = computed(() => paging.state.data)

    store.getRooms()

    watch(pagingData, () => {
      store.checkAll = false
      store.selectedRooms = []
    })

    return {
      store,
      paging,
      actionButton,
      data: pagingData,
      checkColWidth,
    }
  },
})
</script>
