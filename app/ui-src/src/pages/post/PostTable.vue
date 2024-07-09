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
              class="text-left cursor-pointer mobile-only"
              @click="paging.sortData('date')"
            >
              Post <sort-icon />
            </th>
            <th
              class="text-left cursor-pointer mobile-hide"
              @click="paging.sortData('timeline_title')"
            >
              {{ $t('timeline_label_post') }} <sort-icon />
            </th>
            <th class="text-left cursor-pointer mobile-hide">Status</th>
            <th
              class="text-left cursor-pointer mobile-hide"
              @click="paging.sortData('date')"
            >
              {{ $t('timeline_post_date') }} <sort-icon />
            </th>
            <th
              class="text-left cursor-pointer mobile-hide"
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
            <td
              class="text-left mobile-only cursor-pointer"
              @click="viewPost(item.timeline_id)"
            >
              {{ item.timeline_title }} <br />
              <small class="text-grey-8" style="font-size: small">
                <q-icon name="o_schedule" /> {{ item.created }} </small
              ><br />
              <small class="text-grey-8" style="font-size: small">
                <q-icon name="o_mode_edit" /> {{ item.author }} </small
              ><br />
              <small class="text-grey-8" style="font-size: small"
                ><q-icon name="o_info" />&nbsp;</small
              >
              <q-badge
                :color="statusColor(item.timeline_status)"
                :label="status(item.timeline_status)"
              />
            </td>
            <td class="text-left mobile-hide">{{ item.timeline_title }}</td>
            <td class="text-left mobile-hide">
              <q-badge
                :color="statusColor(item.timeline_status)"
                :label="status(item.timeline_status)"
              />
            </td>
            <td class="text-left mobile-hide">{{ item.created }}</td>
            <td class="text-left mobile-hide">{{ item.author }}</td>
            <td class="text-left">
              <q-btn-group
                class="mobile-hide"
                v-if="$q.cookies.get(conf.userType) !== '3'"
              >
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
                  @click="store.getDetail(item.timeline_id, true)"
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
              <q-btn
                v-else
                :class="[actionButton, 'mobile-hide']"
                icon="launch"
                @click="store.getDetail(item.timeline_id, true)"
                ><btn-tooltip :label="$t('timeline_view_post')"
              /></q-btn>
              <q-btn round icon="more_vert" class="mobile-only" unelevated flat>
                <q-menu>
                  <q-list style="min-width: 100px">
                    <q-item
                      clickable
                      v-close-popup
                      @click="store.getDetail(item.timeline_id)"
                      :disable="disable(item.editable)"
                      v-if="$q.cookies.get(conf.userType) !== '3'"
                    >
                      <q-item-section>{{ $t('perbarui') }}</q-item-section>
                    </q-item>
                    <q-item
                      clickable
                      v-close-popup
                      @click="viewPost(item.timeline_id)"
                    >
                      <q-item-section>{{
                        $t('timeline_view_post')
                      }}</q-item-section>
                    </q-item>
                    <q-separator v-if="$q.cookies.get(conf.userType) !== '3'" />
                    <q-item
                      clickable
                      v-close-popup
                      @click="store.showDeleteConfirm(item.timeline_id)"
                      :disable="disable(item.editable)"
                      v-if="$q.cookies.get(conf.userType) !== '3'"
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
import { conf, t } from 'src/composables/common'
import { useRouter } from 'vue-router'

export default defineComponent({
  name: 'PostTable',
  setup() {
    const router = useRouter()
    const store = usePostStore()
    const paging = usePagingStore()
    const pagingData = computed(() => paging.state.data)

    store.getPosts()

    watch(pagingData, () => {
      store.checkAll = false
      store.selectedPosts = []
    })

    const viewPost = (id) => {
      router.push(`/post/view/${id}`)
    }

    return {
      conf,
      store,
      paging,
      viewPost,
      actionButton,
      checkColWidth,
      data: pagingData,
      disable: (editable) => (editable === 1 ? false : true),
      statusColor: (status) => (status === 'draft' ? 'orange-10' : 'teal-8'),
      status: (status) => (status === 'draft' ? 'Draft' : t('timeline_public')),
    }
  },
})
</script>
