<template>
  <div class="q-mt-lg">
    <q-scroll-area class="table-scroll-area">
      <q-markup-table bordered>
        <thead>
          <tr>
            <th class="text-left cursor-pointer"><q-checkbox v-model="$store.state.student.checkAll" @update:model-value="selectAll" /></th>
            <th class="text-left cursor-pointer mobile-hide" @click="sortData('student_nis')">{{ getLang.siswa_nis }} <sort-icon /></th>
            <th class="text-left cursor-pointer" @click="sortData('student_name')">{{ getLang.siswa_nama }} <sort-icon /></th>
            <th class="text-left cursor-pointer mobile-hide" @click="sortData('parent_father_name')">{{ getLang.siswa_label_ayah }} <sort-icon /></th>
            <th class="text-left cursor-pointer mobile-hide" @click="sortData('parent_mother_name')">{{ getLang.siswa_label_ibu }} <sort-icon /></th>
            <th class="text-left">{{ getLang.aksi }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td class="text-left"><q-checkbox v-model="$store.state.student.selectedStudents" :val="item.student_id" /></td>
            <td class="text-left mobile-hide">{{ item.student_nis }}</td>
            <td class="text-left">{{ item.student_name }}</td>
            <td class="text-left mobile-hide">{{ item.parent_father_name }}</td>
            <td class="text-left mobile-hide">{{ item.parent_mother_name }}</td>
            <td class="text-left">
              <q-btn-group class="mobile-hide">
                <q-btn color="accent" icon="edit" @click="getDetail(item.student_id)" />
                <q-btn color="accent" icon="delete" 
                  @click="showDeleteConfirm(item.student_id)" />
              </q-btn-group>
              <q-btn round icon="more_vert" color="accent" class="mobile-only">
                <q-menu>
                  <q-list style="min-width: 100px">
                    <q-item clickable v-close-popup @click="getDetail(item.parent_id)">
                      <q-item-section>{{ getLang.perbarui }}</q-item-section>
                    </q-item>
                    <q-separator />
                    <q-item clickable v-close-popup 
                      @click="showDeleteConfirm(item.student_id)">
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
    <div class="q-pa-sm">
      <div class="row">
        <div class="col-12 col-md-6">
          <p> {{ rowRange }} </p>
        </div>
        <div class="col-12 col-md-2 offset-4">
          <q-pagination
            v-model="$store.state.student.current"
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
import { watch, computed, inject } from 'vue'
import { useStore, mapState, mapMutations, mapActions, mapGetters } from 'vuex'

export default {
  name: 'StudentTable',
  inject: ['textLang'],
  created() {
    setTimeout(() => {
      this.$store.dispatch('student/getStudents')  
    }, 500)
  },
  methods: {
    ...mapActions('student', [
      'onPaginationUpdate',
      'sortData'
    ]),
    ...mapMutations('student', [
      'selectAll', 'getDetail',
      'showDeleteConfirm'
    ])
  },
  computed: {
    ...mapState('student', {
      data: state => state.paging.data,
      pageLinks: state => state.paging.pageLinks,
    }),
    ...mapGetters('student', {
      rowRange: 'rowRange'
    }),
  },
  setup () {
    const store = useStore()
    let pagingData = computed(() => store.state.student.paging.data)
    watch(pagingData, () => {
      store.state.student.checkAll = false
      store.state.student.selectedParents = []
    })

    return {
      getLang: computed(() => inject('textLang')).value
    }
  }
}
</script>