<template>
  <div>
    <q-scroll-area class="table-scroll-area">
      <q-markup-table bordered>
        <thead>
          <tr>
            <th :class="['text-left cursor-pointer', checkColWidth()]"><q-checkbox v-model="$store.state.lesson.checkAll" @update:model-value="selectAll" /></th>
            <th class="text-left cursor-pointer mobile-hide" @click="sortData('lesson_code')">{{ $t('mapel_kode') }} <sort-icon /></th>
            <th class="text-left cursor-pointer" @click="sortData('lesson_name')">{{ $t('mapel_nama') }} <sort-icon /></th>
            <th class="text-left">{{ $t('aksi') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td :class="['text-left', checkColWidth()]"><q-checkbox v-model="$store.state.lesson.selectedLessons" :val="item.lesson_id" /></td>
            <td class="text-left mobile-hide">{{ item.lesson_code }}</td>
            <td class="text-left mobile-hide">{{ item.lesson_name }}</td>
            <td class="text-left mobile-only">{{ $trim(item.lesson_name) }}</td>
            <td class="text-left">
              <q-btn-group class="mobile-hide">
                <q-btn color="accent" icon="edit" @click="getDetail(item.lesson_id)" />
                <q-btn color="accent" icon="delete"
                  @click="showDeleteConfirm(item.lesson_id)" />
              </q-btn-group>
              <q-btn round icon="more_vert" color="accent" class="mobile-only" outline>
                <q-menu>
                  <q-list style="min-width: 100px">
                    <q-item clickable v-close-popup @click="getDetail(item.lesson_id)">
                      <q-item-section>{{ $t('perbarui') }}</q-item-section>
                    </q-item>
                    <q-separator />
                    <q-item clickable v-close-popup 
                      @click="showDeleteConfirm(item.lesson_id)">
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
    <ss-paging vuex-module="lesson" />
  </div>
</template>

<script>
import { watch, computed } from 'vue'
import { useStore, mapState, mapMutations, mapActions } from 'vuex'
import { checkColWidth } from 'src/composables/screen'

export default {
  name: 'LessonTable',
  created() {
    setTimeout(() => {
      this.$store.dispatch('lesson/getLessons')  
    }, 500)
  },
  methods: {
    ...mapActions('lesson', [
      'sortData'
    ]),
    ...mapMutations('lesson', [
      'selectAll', 'getDetail',
      'showDeleteConfirm'
    ])
  },
  computed: {
    ...mapState('lesson', {
      data: state => state.paging.data,
    })
  },
  setup () {
    const store = useStore()
    const pagingData = computed(() => store.state.lesson.paging.data)

    watch(pagingData, () => {
      store.state.lesson.checkAll = false
      store.state.lesson.selectedLessons = []
    })

    return {
      checkColWidth
    }
  }
}
</script>