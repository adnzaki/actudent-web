<template>
  <div>
    <q-scroll-area class="table-scroll-area">
      <q-markup-table bordered>
        <thead>
          <tr>
            <th :class="['text-left cursor-pointer', checkColWidth()]"><q-checkbox v-model="store.checkAll" @update:model-value="store.selectAll()" /></th>
            <th class="text-left cursor-pointer" @click="sortData('grade_name')">{{ $t('kelas_nama') }} <sort-icon /></th>
            <th class="text-left cursor-pointer mobile-hide" @click="sortData('staff_name')">{{ $t('kelas_wali') }} <sort-icon /></th>
            <th class="text-left cursor-pointer mobile-hide">{{ $t('kelas_tahun') }}</th>
            <th class="text-left">{{ $t('aksi') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td :class="['text-left', checkColWidth()]"><q-checkbox v-model="store.selectedClasses" :val="item.grade_id" /></td>
            <td class="text-left mobile-hide">{{ item.grade_name }}</td>
            <td class="text-left mobile-only">
              {{ $trim(item.grade_name, 30) }}<br/>
              <small class="text-grey-8">{{ item.staff_name }}</small>
            </td>
            <td class="text-left mobile-hide">{{ item.staff_name }}</td>
            <td class="text-left mobile-hide">{{ item.period_start }} / {{ item.period_end }}</td>
            <td class="text-left">
              <q-btn-group class="mobile-hide">
                <q-btn color="accent" icon="edit" @click="store.getDetail(item.grade_id)" />
                <q-btn color="accent" icon="group" @click="showGroupMember(item.grade_id, item.grade_name)" />
                <q-btn color="accent" icon="delete" 
                  @click="store.showDeleteConfirm(item.grade_id)" />
              </q-btn-group>
              <q-btn round icon="more_vert" color="accent" class="mobile-only" outline>
                <q-menu>
                  <q-list style="min-width: 100px">
                    <q-item clickable v-close-popup @click="store.getDetail(item.grade_id)">
                      <q-item-section>{{ $t('perbarui') }}</q-item-section>
                    </q-item>
                    <q-separator />
                    <q-item clickable v-close-popup @click="showGroupMember(item.grade_id, item.grade_name)">
                      <q-item-section>{{ $t('kelas_member') }}</q-item-section>
                    </q-item>
                    <q-separator />
                    <q-item clickable v-close-popup 
                      @click="store.showDeleteConfirm(item.grade_id)">
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
import { useRouter } from 'vue-router'
import { checkColWidth } from 'src/composables/screen'
import { useClassStore } from 'src/stores/class'
import { usePagingStore } from 'ss-paging-vue'

export default {
  name: 'ClassTable',
  setup () {
    const store = useClassStore()
    const router = useRouter()
    const paging = usePagingStore()
    const pagingData = computed(() => paging.store.data)

    watch(pagingData, () => {
      store.checkAll = false
      store.selectedClasses = []
    })

    const showGroupMember = (id, name) => {
      store.classMember.name = name
      router.push(`/class/member/${id}`)
    }

    store.getClassList()

    return {
      store,
      data: pagingData,
      checkColWidth,
      showGroupMember
    }
  }
}
</script>