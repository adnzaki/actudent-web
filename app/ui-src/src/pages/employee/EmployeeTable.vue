<template>
  <div>
    <q-scroll-area class="table-scroll-area">
      <q-markup-table bordered>
        <thead>
          <tr>
            <th :class="['text-left cursor-pointer', checkColWidth()]">
              <q-checkbox
                v-model="store.checkAll"
                @update:model-value="selectAll"
              />
            </th>
            <th
              class="text-left cursor-pointer mobile-hide"
              @click="sortData('staff_nik')"
            >
              {{ $t('staff_id') }} <sort-icon />
            </th>
            <th
              class="text-left cursor-pointer"
              @click="sortData('staff_name')"
            >
              {{ $t('staff_nama') }} <sort-icon />
            </th>
            <th class="text-left cursor-pointer mobile-hide">
              {{ $t('staff_label_telp') }} <sort-icon />
            </th>
            <th
              class="text-left cursor-pointer mobile-hide"
              @click="sortData('staff_title')"
            >
              {{ $t('staff_label_jabatan') }} <sort-icon />
            </th>
            <th class="text-left">{{ $t('aksi') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td :class="['text-left', checkColWidth()]">
              <q-checkbox
                v-model="store.selectedEmployees"
                :val="`${item.staff_id}-${item.user_id}`"
              />
            </td>
            <td class="text-left mobile-hide">{{ item.staff_nik }}</td>
            <td class="text-left">{{ item.staff_name }}</td>
            <td class="text-left mobile-hide">{{ item.staff_phone }}</td>
            <td class="text-left mobile-hide">{{ item.staff_title }}</td>
            <td class="text-left">
              <q-btn-group class="mobile-hide">
                <q-btn
                  color="accent"
                  icon="edit"
                  @click="getDetail(item.user_id)"
                />
                <q-btn
                  color="accent"
                  icon="delete"
                  @click="
                    showDeleteConfirm({
                      staff: item.staff_id,
                      user: item.user_id,
                    })
                  "
                />
              </q-btn-group>
              <q-btn
                round
                icon="more_vert"
                color="accent"
                class="mobile-only"
                outline
              >
                <q-menu>
                  <q-list style="min-width: 100px">
                    <q-item
                      clickable
                      v-close-popup
                      @click="getDetail(item.user_id)"
                    >
                      <q-item-section>{{ $t('perbarui') }}</q-item-section>
                    </q-item>
                    <q-separator />
                    <q-item
                      clickable
                      v-close-popup
                      @click="
                        showDeleteConfirm({
                          staff: item.staff_id,
                          user: item.user_id,
                        })
                      "
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
import { watch, computed } from 'vue'
import { usePagingStore } from 'ss-paging-vue'
import { useEmployeeStore } from 'src/stores/employee'
import { checkColWidth } from 'src/composables/screen'

export default {
  setup() {
    const paging = usePagingStore()
    const store = useEmployeeStore()

    store.getEmployee()

    let pagingData = computed(() => paging.data)
    watch(pagingData, () => {
      store.checkAll = false
      store.selectedEmployees = []
    })

    return {
      store,
      checkColWidth,
      data: computed(() => paging.state.data),
      selectAll: () => store.selectAll(),
      getDetail: (id) => store.getDetail(id),
      sortData: (field) => paging.sortData(field),
      showDeleteConfirm: (param) => store.showDeleteConfirm(param),
    }
  },
}
</script>
