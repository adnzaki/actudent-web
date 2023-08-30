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
              class="text-left cursor-pointer"
              @click="paging.sortData('timeline_title')"
            >
              {{ $t('timeline_label_post') }} <sort-icon />
            </th>
            <th
              class="text-left cursor-pointer"
              @click="paging.sortData('timeline_content')"
            >
              {{ $t('timeline_label_content') }} <sort-icon />
            </th>
            <th
              class="text-left cursor-pointer"
              @click="paging.sortData('date')"
            >
              {{ $t('timeline_post_date') }} <sort-icon />
            </th>
            <th
              class="text-left cursor-pointer"
              @click="paging.sortData('author')"
            >
              {{ $t('timeline_posted_by') }} <sort-icon />
            </th>
            <th class="text-left">{{ $t('aksi') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td :class="['text-left', checkColWidth()]">
              <q-checkbox
                v-model="store.selectedPosts"
                :val="item.timeline_id"
              />
            </td>
            <td class="text-left">{{ item.timeline_title }}</td>
            <td class="text-left">{{ $trim(item.timeline_content, 50) }}</td>
            <td class="text-left">{{ item.created }}</td>
            <td class="text-left">{{ item.author }}</td>
            <td class="text-left">
              <q-btn-group class="mobile-hide">
                <q-btn
                  :class="actionButton"
                  icon="edit"
                  @click="store.getDetail(item.timeline_id)"
                  :disable="disable(item.editable)"
                >
                  <btn-tooltip :label="$t('perbarui')"
                /></q-btn>
                <q-btn
                  :class="actionButton"
                  icon="launch"
                  @click="store.getDetail(item.timeline_id)"
                  ><btn-tooltip :label="$t('timeline_view_post')"
                /></q-btn>
                <q-btn
                  :class="actionButton"
                  icon="delete"
                  @click="store.showDeleteConfirm(item.timeline_id)"
                  :disable="disable(item.editable)"
                  ><btn-tooltip :label="$t('hapus')"
                /></q-btn>
              </q-btn-group>
              <q-btn round icon="more_vert" class="mobile-only" unelevated flat>
                <q-menu>
                  <q-list style="min-width: 100px">
                    <q-item
                      clickable
                      v-close-popup
                      @click="store.getDetail(item.timeline_id)"
                      :disable="disable(item.editable)"
                    >
                      <q-item-section>{{ $t('perbarui') }}</q-item-section>
                    </q-item>
                    <q-item
                      clickable
                      v-close-popup
                      @click="store.getDetail(item.timeline_id)"
                    >
                      <q-item-section>{{
                        $t('timeline_view_post')
                      }}</q-item-section>
                    </q-item>
                    <q-separator />
                    <q-item
                      clickable
                      v-close-popup
                      @click="store.showDeleteConfirm(item.timeline_id)"
                      :disable="disable(item.editable)"
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
import { usePostStore } from 'src/stores/post'
import { usePagingStore } from 'ss-paging-vue'
import { actionButton } from 'src/composables/mode'

export default defineComponent({
  name: 'PostTable',
  setup() {
    const store = usePostStore()
    const paging = usePagingStore()
    const pagingData = computed(() => paging.state.data)

    store.getPosts()

    watch(pagingData, () => {
      store.checkAll = false
      store.selectedPosts = []
    })

    return {
      store,
      paging,
      actionButton,
      data: pagingData,
      checkColWidth,
      disable: (editable) => (editable === 1 ? false : true),
    }
  },
})
</script>
