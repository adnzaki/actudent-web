<template>
  <div>
    <q-scroll-area class="table-scroll-area">
      <q-markup-table bordered>
        <thead>
          <tr>
            <th :class="['text-left cursor-pointer', checkColWidth()]">
              <q-checkbox
                v-model="store.checkAll"
                @update:model-value="store.selectAll()"
              />
            </th>
            <th
              class="text-left cursor-pointer mobile-hide"
              @click="paging.sortData('lesson_code')"
            >
              {{ $t('mapel_kode') }} <sort-icon />
            </th>
            <th
              class="text-left cursor-pointer"
              @click="paging.sortData('lesson_name')"
            >
              {{ $t('mapel_nama') }} <sort-icon />
            </th>
            <th class="text-left">{{ $t('aksi') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td :class="['text-left', checkColWidth()]">
              <q-checkbox
                v-model="store.selectedLessons"
                :val="item.lesson_id"
              />
            </td>
            <td class="text-left mobile-hide">{{ item.lesson_code }}</td>
            <td class="text-left mobile-hide">{{ item.lesson_name }}</td>
            <td class="text-left mobile-only">{{ $trim(item.lesson_name) }}</td>
            <td class="text-left">
              <q-btn-group class="mobile-hide">
                <q-btn
                  color="accent"
                  icon="edit"
                  @click="store.getDetail(item.lesson_id)"
                />
                <q-btn
                  color="accent"
                  icon="delete"
                  @click="store.showDeleteConfirm(item.lesson_id)"
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
                      @click="store.getDetail(item.lesson_id)"
                    >
                      <q-item-section>{{ $t('perbarui') }}</q-item-section>
                    </q-item>
                    <q-separator />
                    <q-item
                      clickable
                      v-close-popup
                      @click="store.showDeleteConfirm(item.lesson_id)"
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
import { useLessonStore } from 'src/stores/lesson'
import { checkColWidth } from 'src/composables/screen'

export default {
  name: 'LessonTable',
  setup() {
    const store = useLessonStore()
    const paging = usePagingStore()

    const pagingData = computed(() => paging.state.data)

    store.getLessons()

    watch(pagingData, () => {
      store.checkAll = false
      store.selectedLessons = []
    })

    return {
      store,
      paging,
      checkColWidth,
      data: computed(() => paging.state.data),
    }
  },
}
</script>
