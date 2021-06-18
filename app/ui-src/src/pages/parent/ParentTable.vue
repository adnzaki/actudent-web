<template>
  <div>
    <q-scroll-area class="table-scroll-area">
      <q-markup-table bordered>
        <thead>
          <tr>
            <th class="text-left cursor-pointer"><q-checkbox v-model="$store.state.parent.checkAll" @update:model-value="selectAll" /></th>
            <th class="text-left cursor-pointer mobile-hide" @click="sortData('parent_family_card')">{{ lang.ortu_kk }} <sort-icon /></th>
            <th class="text-left cursor-pointer" @click="sortData('parent_father_name')">{{ lang.ortu_label_ayah }} <sort-icon /></th>
            <th class="text-left cursor-pointer" @click="sortData('parent_mother_name')">{{ lang.ortu_label_ibu }} <sort-icon /></th>
            <th class="text-left mobile-hide">{{ lang.ortu_label_telp }}</th>
            <th class="text-left">{{ lang.aksi }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td class="text-left"><q-checkbox v-model="$store.state.parent.selectedParents" :val="`${item.parent_id}-${item.user_id}`" /></td>
            <td class="text-left mobile-hide">{{ item.parent_family_card }}</td>
            <td class="text-left">{{ item.parent_father_name }}</td>
            <td class="text-left">{{ item.parent_mother_name }}</td>
            <td class="text-left mobile-hide">{{ item.parent_phone_number }}</td>
            <td class="text-left">
              <q-btn-group class="mobile-hide">
                <q-btn color="accent" icon="edit" @click="getDetail(item.parent_id)" />
                <q-btn color="accent" icon="delete" />
              </q-btn-group>
              <q-btn round icon="more_vert" color="accent" class="mobile-only">
                <q-menu>
                  <q-list style="min-width: 100px">
                    <q-item clickable v-close-popup @click="getDetail(item.parent_id)">
                      <q-item-section>{{ lang.perbarui }}</q-item-section>
                    </q-item>
                    <q-separator />
                    <q-item clickable v-close-popup>
                      <q-item-section>{{ lang.hapus }}</q-item-section>
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
    <div class="q-pa-sm">
      <div class="row">
        <div class="col-12 col-md-6">
          <p> {{ rowRange }} </p>
        </div>
        <div class="col-12 col-md-2 offset-4">
          <q-pagination
            v-model="$store.state.parent.current"
            :max="pageLinks.length"
            input
            @update:model-value="onPaginationUpdate"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import SortIcon from 'components/SortIcon'
import { mapState, mapMutations, mapActions, mapGetters } from 'vuex'

export default {
  name: 'ParentTable',
  props: ['lang'],
  components: { SortIcon },
  created() {
    setTimeout(() => {
      this.$store.dispatch('parent/getOrtu')  
    }, 500)
  },
  methods: {
    ...mapActions('parent', [
      'onPaginationUpdate',
      'sortData'
    ]),
    ...mapMutations('parent', [
      'selectAll', 'getDetail'
    ])
  },
  computed: {
    ...mapState('parent', {
      data: state => state.paging.data,
      pageLinks: state => state.paging.pageLinks,
    }),
    ...mapGetters('parent', {
      rowRange: 'rowRange'
    })
  },
  setup () {
    return {}
  }
}
</script>