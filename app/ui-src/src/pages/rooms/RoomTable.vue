<template>
  <div>
    <q-scroll-area class="table-scroll-area">
      <q-markup-table bordered>
        <thead>
          <tr>
            <th :class="['text-left cursor-pointer', checkColWidth()]"><q-checkbox v-model="$store.state.rooms.checkAll" @update:model-value="selectAll" /></th>
            <th class="text-left cursor-pointer mobile-hide" @click="sortData('room_code')">{{ $t('ruang_kode') }} <sort-icon /></th>
            <th class="text-left cursor-pointer" @click="sortData('room_name')">{{ $t('ruang_nama') }} <sort-icon /></th>
            <th class="text-left">{{ $t('aksi') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td :class="['text-left', checkColWidth()]"><q-checkbox v-model="$store.state.rooms.selectedRooms" :val="item.room_id" /></td>
            <td class="text-left mobile-hide">{{ item.room_code }}</td>
            <td class="text-left">{{ item.room_name }}</td>
            <td class="text-left">
              <q-btn-group class="mobile-hide">
                <q-btn color="accent" icon="edit" @click="getDetail(item.room_id)" />
                <q-btn color="accent" icon="delete" 
                  @click="showDeleteConfirm(item.room_id)" />
              </q-btn-group>
              <q-btn round icon="more_vert" color="accent" class="mobile-only" outline>
                <q-menu>
                  <q-list style="min-width: 100px">
                    <q-item clickable v-close-popup @click="getDetail(item.room_id)">
                      <q-item-section>{{ $t('perbarui') }}</q-item-section>
                    </q-item>
                    <q-separator />
                    <q-item clickable v-close-popup 
                      @click="showDeleteConfirm(item.room_id)">
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
    <q-separator/>
    <ss-paging vuex-module="rooms" />
  </div>
</template>

<script>
import { watch, computed } from 'vue'
import { useStore, mapState, mapMutations, mapActions } from 'vuex'
import { checkColWidth } from 'src/composables/screen'

export default {
  name: 'RoomTable',
  created() {
    setTimeout(() => {
      this.$store.dispatch('rooms/getRooms')  
    }, 500)
  },
  methods: {
    ...mapActions('rooms', [
      'sortData'
    ]),
    ...mapMutations('rooms', [
      'selectAll', 'getDetail',
      'showDeleteConfirm'
    ])
  },
  computed: {
    ...mapState('rooms', {
      data: state => state.paging.data,
    })
  },
  setup () {
    const store = useStore()
    const pagingData = computed(() => store.state.rooms.paging.data)

    watch(pagingData, () => {
      store.state.rooms.checkAll = false
      store.state.rooms.selectedRooms = []
    })

    return {
      checkColWidth
    }
  }
}
</script>