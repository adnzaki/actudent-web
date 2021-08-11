<template>
  <div>
    <q-scroll-area class="table-scroll-area">
      <q-markup-table bordered>
        <thead>
          <tr>
            <th :class="['text-left cursor-pointer', checkColWidth()]"><q-checkbox v-model="$store.state.employee.checkAll" @update:model-value="selectAll" /></th>
            <th class="text-left cursor-pointer mobile-hide" @click="sortData('staff_nik')">{{ getLang.staff_id }} <sort-icon /></th>
            <th class="text-left cursor-pointer" @click="sortData('staff_name')">{{ getLang.staff_nama }} <sort-icon /></th>
            <th class="text-left cursor-pointer mobile-hide">{{ getLang.staff_label_telp }} <sort-icon /></th>
            <th class="text-left cursor-pointer mobile-hide" @click="sortData('staff_title')">{{ getLang.staff_label_jabatan }} <sort-icon /></th>
            <th class="text-left">{{ getLang.aksi }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td :class="['text-left', checkColWidth()]"><q-checkbox v-model="$store.state.employee.selectedEmployees" :val="`${item.staff_id}-${item.user_id}`" /></td>
            <td class="text-left mobile-hide">{{ item.staff_nik }}</td>
            <td class="text-left">{{ item.staff_name }}</td>
            <td class="text-left mobile-hide">{{ item.staff_phone }}</td>
            <td class="text-left mobile-hide">{{ item.staff_title }}</td>
            <td class="text-left">
              <q-btn-group class="mobile-hide">
                <q-btn color="accent" icon="edit" @click="getDetail(item.user_id)" />
                <q-btn color="accent" icon="delete" 
                  @click="showDeleteConfirm({ staff: item.staff_id, user: item.user_id })" />
              </q-btn-group>
              <q-btn round icon="more_vert" color="accent" class="mobile-only" outline>
                <q-menu>
                  <q-list style="min-width: 100px">
                    <q-item clickable v-close-popup @click="getDetail(item.user_id)">
                      <q-item-section>{{ getLang.perbarui }}</q-item-section>
                    </q-item>
                    <q-separator />
                    <q-item clickable v-close-popup 
                      @click="showDeleteConfirm({ staff: item.staff_id, user: item.user_id })">
                      <q-item-section>{{ getLang.hapus }}</q-item-section>
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
    <ss-paging vuex-module="employee" />
  </div>
</template>

<script>
import { watch, computed, inject } from 'vue'
import { useStore, mapState, mapMutations, mapActions } from 'vuex'
import { checkColWidth } from 'src/composables/screen'

export default {
  name: 'EmployeeTable',
  created() {
    setTimeout(() => {
      this.$store.dispatch('employee/getEmployee')  
    }, 500)
  },
  methods: {
    ...mapActions('employee', [
      'sortData'
    ]),
    ...mapMutations('employee', [
      'selectAll', 'getDetail',
      'showDeleteConfirm'
    ])
  },
  computed: {
    ...mapState('employee', {
      data: state => state.paging.data,
    })
  },
  setup () {
    const store = useStore()
    let pagingData = computed(() => store.state.employee.paging.data)
    watch(pagingData, () => {
      store.state.employee.checkAll = false
      store.state.employee.selectedEmployees = []
    })

    return {
      getLang: computed(() => inject('textLang')).value,
      checkColWidth
    }
  }
}
</script>