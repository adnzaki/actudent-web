<template>
  <div>
    <q-scroll-area class="table-scroll-area">
      <q-markup-table bordered>
        <thead>
          <tr>
            <th :class="['text-left cursor-pointer', checkColWidth()]"><q-checkbox v-model="$store.state.parent.checkAll" @update:model-value="selectAll" /></th>
            <th class="text-left cursor-pointer mobile-only" @click="sortData('parent_father_name')">{{ $t('ortu_label_parent') }} <sort-icon /></th>
            <th class="text-left cursor-pointer mobile-hide" @click="sortData('parent_family_card')">{{ $t('ortu_kk') }} <sort-icon /></th>
            <th class="text-left cursor-pointer mobile-hide" @click="sortData('parent_father_name')">{{ $t('ortu_label_ayah') }} <sort-icon /></th>
            <th class="text-left cursor-pointer mobile-hide" @click="sortData('parent_mother_name')">{{ $t('ortu_label_ibu') }} <sort-icon /></th>
            <th class="text-left mobile-hide">{{ $t('ortu_label_telp') }}</th>
            <th class="text-left">{{ $t('aksi') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td :class="['text-left', checkColWidth()]"><q-checkbox v-model="$store.state.parent.selectedParents" :val="`${item.parent_id}-${item.user_id}`" /></td>
            <td class="text-left mobile-only">{{ item.parent_father_name }} / <br/> {{ item.parent_mother_name }}</td>
            <td class="text-left mobile-hide">{{ item.parent_family_card }}</td>
            <td class="text-left mobile-hide">{{ item.parent_father_name }}</td>
            <td class="text-left mobile-hide">{{ item.parent_mother_name }}</td>
            <td class="text-left mobile-hide">{{ item.parent_phone_number }}</td>
            <td class="text-left">
              <q-btn-group class="mobile-hide">
                <q-btn color="accent" icon="edit" @click="getDetail(item.parent_id)" />
                <q-btn color="accent" icon="delete" 
                  @click="showDeleteConfirm(`${item.parent_id}-${item.user_id}`)" />
              </q-btn-group>
              <q-btn round icon="more_vert" color="accent" class="mobile-only" outline>
                <q-menu>
                  <q-list style="min-width: 100px">
                    <q-item clickable v-close-popup @click="getDetail(item.parent_id)">
                      <q-item-section>{{ $t('perbarui') }}</q-item-section>
                    </q-item>
                    <q-separator />
                    <q-item clickable v-close-popup 
                      @click="showDeleteConfirm(`${item.parent_id}-${item.user_id}`)">
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
    <ss-paging vuex-module="parent" />
  </div>
</template>

<script>
import { watch, computed } from 'vue'
import { useStore, mapState, mapMutations, mapActions } from 'vuex'
import { checkColWidth } from 'src/composables/screen'

export default {
  name: 'ParentTable',
  created() {
    setTimeout(() => {
      this.$store.dispatch('parent/getOrtu')  
    }, 500)
  },
  methods: {
    ...mapActions('parent', [
      'sortData'
    ]),
    ...mapMutations('parent', [
      'selectAll', 'getDetail',
      'showDeleteConfirm'
    ])
  },
  computed: {
    ...mapState('parent', {
      data: state => state.paging.data,
    })
  },
  setup () {
    const store = useStore()
    let pagingData = computed(() => store.state.parent.paging.data)
    watch(pagingData, () => {
      store.state.parent.checkAll = false
      store.state.parent.selectedParents = []
    })

    return { checkColWidth }
  }
}
</script>