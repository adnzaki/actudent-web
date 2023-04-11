<template>
  <div>
    <q-scroll-area class="table-scroll-area">
      <q-markup-table bordered>
        <thead>
          <tr>
            <th :class="['text-left cursor-pointer', checkColWidth()]"><q-checkbox v-model="store.checkAll" @update:model-value="selectAll" /></th>
            <th class="text-left cursor-pointer mobile-hide" @click="sortData('student_nis')">{{ $t('siswa_nis') }} <sort-icon /></th>
            <th class="text-left cursor-pointer" @click="sortData('student_name')">{{ $t('siswa_nama') }} <sort-icon /></th>
            <th class="text-left cursor-pointer mobile-hide" @click="sortData('parent_father_name')">{{ $t('siswa_label_ayah') }} <sort-icon /></th>
            <th class="text-left cursor-pointer mobile-hide" @click="sortData('parent_mother_name')">{{ $t('siswa_label_ibu') }} <sort-icon /></th>
            <th class="text-left">{{ $t('aksi') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td :class="['text-left', checkColWidth()]"><q-checkbox v-model="store.selectedStudents" :val="item.student_id" /></td>
            <td class="text-left mobile-hide">{{ item.student_nis }}</td>
            <td class="text-left mobile-hide">{{ item.student_name }}</td>
            <td class="text-left mobile-only">{{ $trim(item.student_name, 30) }}</td>
            <td class="text-left mobile-hide">{{ item.parent_father_name }}</td>
            <td class="text-left mobile-hide">{{ item.parent_mother_name }}</td>
            <td class="text-left">
              <q-btn-group class="mobile-hide">
                <q-btn color="accent" icon="edit" @click="getDetail(item.student_id)" />
                <q-btn color="accent" icon="delete" 
                  @click="showDeleteConfirm(item.student_id)" />
              </q-btn-group>
              <q-btn round icon="more_vert" color="accent" class="mobile-only" outline>
                <q-menu>
                  <q-list style="min-width: 100px">
                    <q-item clickable v-close-popup @click="getDetail(item.student_id)">
                      <q-item-section>{{ $t('perbarui') }}</q-item-section>
                    </q-item>
                    <q-separator />
                    <q-item clickable v-close-popup 
                      @click="showDeleteConfirm(item.student_id)">
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
    <ss-paging :store="store" />
  </div>
</template>

<script>
import { watch, computed } from 'vue'
import { useStudentStore } from 'src/stores/student'
import { usePagingStore } from 'ss-paging-vue'
import { checkColWidth } from 'src/composables/screen'

export default {
  setup () {
    const store = useStudentStore()
    const paging = usePagingStore()
    const pagingData = computed(() => paging.state.data)

    store.getStudents()
    
    watch(pagingData, () => {
      store.checkAll = false
      store.selectedStudents = []
    })    

    return {
      store,
      checkColWidth,
      data: paging.state.data,
      selectAll: () => store.selectAll(),
      getDetail: id => store.getDetail(id),
      sortData: field => paging.sortData(field),
      showDeleteConfirm: param => store.showDeleteConfirm(param),
    }
  }
}
</script>