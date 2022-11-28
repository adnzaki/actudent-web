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
              <q-btn color="accent" icon="o_autorenew" @click="getDetail(item.id)">
                <btn-tooltip :label="$t('user_reset_password')" />
              </q-btn>
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

export default {
  setup () {
    const store = useStore()

    return {
      sortData: sortBy => store.dispatch('users/sortData', sortBy),
      getDetail: id => store.dispatch('users/getUserDetail', id),
      data: computed(() => store.state.users.paging.data),
      checkColWidth
    }
  }
}
</script>