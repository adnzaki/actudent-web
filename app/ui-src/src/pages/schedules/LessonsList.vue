<template>
  <div>
    <q-scroll-area class="no-paging-scroll-area">
      <q-markup-table bordered>
        <thead>
          <tr>
            <th :class="['text-left cursor-pointer', checkColWidth()]"><q-checkbox v-model="$store.state.schedule.lesson.checkAll" @update:model-value="selectAllLessons" /></th>
            <th class="text-left cursor-pointer">{{ $t('jadwal_nama_mapel') }} <sort-icon /></th>
            <th class="text-left cursor-pointer mobile-hide">{{ $t('jadwal_guru_mapel') }} <sort-icon /></th>
            <th class="text-left">{{ $t('aksi') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td :class="['text-left', checkColWidth()]"><q-checkbox v-model="$store.state.schedule.lesson.selected" :val="item.lessons_grade_id" /></td>
            <td class="text-left">{{ item.lesson_name }} ({{ item.lesson_code }})</td>
            <td class="text-left mobile-hide">{{ item.teacher }}</td>
            <td class="text-left">
              <q-btn-group class="mobile-hide">
                <q-btn color="accent" icon="edit" @click="getDetailLesson(item.lessons_grade_id)" />
                <q-btn color="accent" icon="delete" 
                  @click="showDeleteConfirm(item.lessons_grade_id)" />
              </q-btn-group>
              <q-btn round icon="more_vert" color="accent" class="mobile-only" outline>
                <q-menu>
                  <q-list style="min-width: 100px">
                    <q-item clickable v-close-popup @click="getDetailLesson(item.lessons_grade_id)">
                      <q-item-section>{{ $t('perbarui') }}</q-item-section>
                    </q-item>
                    <q-separator />
                    <q-item clickable v-close-popup @click="showDeleteConfirm(item.lessons_grade_id)">
                      <q-item-section>{{ $t('hapus') }}</q-item-section>
                    </q-item>
                    <q-separator />
                  </q-list>
                </q-menu>
              </q-btn>
            </td>
          </tr>
        </tbody>
      </q-markup-table>
    </q-scroll-area>
    <q-separator/>
  </div>
</template>

<script>
import { mapState, mapActions, mapMutations } from 'vuex'
import { checkColWidth } from 'src/composables/screen'

export default {
  name: 'LessonsList',
  created() {
    setTimeout(() => {
      this.$store.commit('schedule/getLessonsList', this.$route.params.id)  
    }, 500)
  },
  methods: {
    ...mapActions('schedule', [
      
    ]),
    ...mapMutations('schedule', [
      'selectAllLessons', 'showDeleteConfirm',
      'getDetailLesson'
    ])
  },
  computed: {
    ...mapState('schedule', {
      data: state => state.lesson.list,
    })
  },
  setup () {

    return {
      checkColWidth
    }
  }
}
</script>