<template>
  <div>
    <q-markup-table>
      <thead>
        <tr>
          <th class="text-left cursor-pointer" @click="sortData('parent_family_card')">{{ lang.ortu_kk }} <sort-icon /></th>
          <th class="text-left cursor-pointer" @click="sortData('parent_father_name')">{{ lang.ortu_label_ayah }} <sort-icon /></th>
          <th class="text-left cursor-pointer" @click="sortData('parent_mother_name')">{{ lang.ortu_label_ibu }} <sort-icon /></th>
          <th class="text-left">{{ lang.ortu_label_telp }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in data" :key="index">
          <td class="text-left">{{ item.parent_family_card }}</td>
          <td class="text-left">{{ item.parent_father_name }}</td>
          <td class="text-left">{{ item.parent_mother_name }}</td>
          <td class="text-left">{{ item.parent_phone_number }}</td>
        </tr>
      </tbody>
    </q-markup-table>
    <div class="q-pa-lg flex flex-center">
      <q-pagination class="flex flex-center"
        v-model="$store.state.parent.current"
        :max="pageLinks.length"
        input
        @update:model-value="onPaginationUpdate"
      />
    </div>
  </div>
</template>

<script>
import { defineComponent } from 'vue'
import SortIcon from 'components/SortIcon'
import { mapState, mapActions } from 'vuex'

export default defineComponent({
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
  },
  computed: {
    ...mapState('parent', {
      data: state => state.paging.data,
      pageLinks: state => state.paging.pageLinks
    }),    
  },
  setup () {
    return {

}
  }
})
</script>