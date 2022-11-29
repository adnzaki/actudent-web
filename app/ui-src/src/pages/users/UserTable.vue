<template>
  <div>
    <q-scroll-area class="table-scroll-area">
      <q-markup-table bordered>
        <thead>
          <tr>
            <th class="text-center cursor-pointer">#</th>
            <th class="text-left cursor-pointer" @click="sortData('user_name')">{{ $t('user_label_nama') }} <sort-icon /></th>
            <th class="text-left cursor-pointer mobile-hide" @click="sortData('user_email')">{{ $t('user_label_email') }} <sort-icon /></th>
            <th class="text-left cursor-pointer mobile-hide">Status</th>
            <th class="text-left">{{ $t('aksi') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td class="text-center">{{ $store.getters['users/itemNumber'](index) }}</td>
            <td class="text-left">{{ item.name }}</td>
            <td class="text-left mobile-hide">{{ item.email }}</td>
            <td class="text-left mobile-hide">{{ item.level }}</td>
            <td class="text-left">
              <q-btn v-if="conf.mode === 'production'" color="accent" icon="o_autorenew" @click="getDetail(item.id)">
                <btn-tooltip :label="$t('user_reset_password')" />
              </q-btn>
              <div v-else>
                <q-btn-group class="mobile-hide">
                  <q-btn color="accent" icon="o_autorenew" @click="getDetail(item.id)">
                    <btn-tooltip :label="$t('user_reset_password')" />
                  </q-btn>
                  <q-btn color="accent" icon="o_person_off" 
                    @click="showDeactivateConfirm(item.id)">
                    <btn-tooltip :label="$t('user_deactivate')" />
                  </q-btn>
                </q-btn-group>
                <q-btn round icon="more_vert" color="accent" class="mobile-only" outline>
                  <q-menu>
                    <q-list style="min-width: 100px">
                      <q-item clickable v-close-popup @click="getDetail(item.id)">
                        <q-item-section>{{ $t('user_reset_password') }}</q-item-section>
                      </q-item>
                      <q-separator />
                      <q-item clickable v-close-popup 
                        @click="showDeactivateConfirm(item.id)">
                        <q-item-section>{{ $t('user_deactivate') }}</q-item-section>
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
    <q-separator/>
    <ss-paging vuex-module="users" />
  </div>
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'
import { checkColWidth } from 'src/composables/screen'
import { conf } from 'src/composables/common'

export default {
  setup () {
    const store = useStore()

    return {
      conf,
      showDeactivateConfirm: id => store.commit('users/showDeactivateConfirm', id),
      sortData: sortBy => store.dispatch('users/sortData', sortBy),
      getDetail: id => store.dispatch('users/getUserDetail', id),
      data: computed(() => store.state.users.paging.data),
      checkColWidth
    }
  }
}
</script>