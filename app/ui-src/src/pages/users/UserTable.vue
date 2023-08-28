<template>
  <div>
    <q-scroll-area class="table-scroll-area">
      <q-markup-table bordered wrap-cells>
        <thead>
          <tr>
            <th class="text-center cursor-pointer mobile-hide">#</th>
            <th class="text-left cursor-pointer" @click="sortData('user_name')">
              {{ $t('user_label_nama') }} <sort-icon />
            </th>
            <th
              class="text-left cursor-pointer mobile-hide"
              @click="sortData('user_email')"
            >
              {{ $t('user_label_email') }} <sort-icon />
            </th>
            <th class="text-left cursor-pointer mobile-hide">Status</th>
            <th class="text-left">{{ $t('aksi') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td class="text-center mobile-hide">
              {{ paging.itemNumber(index) }}
            </td>
            <td class="text-left mobile-hide">{{ item.name }}</td>
            <td class="text-left mobile-only">
              {{ item.name }}<br />
              <small class="text-grey-7">{{ item.email }}</small
              ><br />
              <q-badge color="primary">{{ item.level }}</q-badge>
            </td>
            <td class="text-left mobile-hide">{{ item.email }}</td>
            <td class="text-left mobile-hide">{{ item.level }}</td>
            <td class="text-left">
              <q-btn
                v-if="conf.mode === 'production'"
                :class="actionButton"
                icon="o_autorenew"
                @click="getDetail(item.id)"
              >
                <btn-tooltip :label="$t('user_reset_password')" />
              </q-btn>
              <div v-else>
                <q-btn-group class="mobile-hide">
                  <q-btn
                    :class="actionButton"
                    icon="o_autorenew"
                    @click="getDetail(item.id)"
                  >
                    <btn-tooltip :label="$t('user_reset_password')" />
                  </q-btn>
                  <q-btn
                    :class="actionButton"
                    icon="o_person_off"
                    @click="showDeactivateConfirm(item.id)"
                  >
                    <btn-tooltip :label="$t('user_deactivate')" />
                  </q-btn>
                </q-btn-group>
                <q-btn
                  round
                  icon="more_vert"
                  class="mobile-only"
                  flat
                  unelevated
                >
                  <q-menu>
                    <q-list style="min-width: 100px">
                      <q-item
                        clickable
                        v-close-popup
                        @click="getDetail(item.id)"
                      >
                        <q-item-section>{{
                          $t('user_reset_password')
                        }}</q-item-section>
                      </q-item>
                      <q-separator />
                      <q-item
                        clickable
                        v-close-popup
                        @click="showDeactivateConfirm(item.id)"
                      >
                        <q-item-section>{{
                          $t('user_deactivate')
                        }}</q-item-section>
                      </q-item>
                    </q-list>
                  </q-menu>
                </q-btn>
              </div>
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
import { computed } from 'vue'
import { conf } from 'src/composables/common'
import { useUserStore } from 'src/stores/user'
import { usePagingStore } from 'ss-paging-vue'
import { checkColWidth } from 'src/composables/screen'
import { actionButton } from 'src/composables/common'

export default {
  setup() {
    const store = useUserStore()
    const paging = usePagingStore()

    return {
      conf,
      store,
      paging,
      actionButton,
      checkColWidth,
      data: computed(() => paging.state.data),
      getDetail: (id) => store.getUserDetail(id),
      sortData: (sortBy) => store.sortData(sortBy),
      showDeactivateConfirm: (id) => store.showDeactivateConfirm(id),
    }
  },
}
</script>
