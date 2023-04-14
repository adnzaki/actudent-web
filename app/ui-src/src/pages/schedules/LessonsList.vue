<template>
  <div>
    <q-scroll-area class="no-paging-scroll-area">
      <q-markup-table bordered>
        <thead>
          <tr>
            <th :class="['text-left cursor-pointer', checkColWidth()]">
              <q-checkbox
                v-model="store.lesson.checkAll"
                @update:model-value="selectAllLessons"
              />
            </th>
            <th class="text-left cursor-pointer">
              {{ $t("jadwal_nama_mapel") }} <sort-icon />
            </th>
            <th class="text-left cursor-pointer mobile-hide">
              {{ $t("jadwal_guru_mapel") }} <sort-icon />
            </th>
            <th class="text-left">{{ $t("aksi") }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td :class="['text-left', checkColWidth()]">
              <q-checkbox
                v-model="store.lesson.selected"
                :val="item.lessons_grade_id"
              />
            </td>
            <td class="text-left mobile-hide">
              {{ item.lesson_name }} ({{ item.lesson_code }})
            </td>
            <td class="text-left mobile-only">{{ $trim(item.lesson_name) }}</td>
            <td class="text-left mobile-hide">{{ item.teacher }}</td>
            <td class="text-left">
              <q-btn-group class="mobile-hide">
                <q-btn
                  color="accent"
                  icon="edit"
                  @click="store.getDetailLesson(item.lessons_grade_id)"
                />
                <q-btn
                  color="accent"
                  icon="delete"
                  @click="store.showDeleteConfirm(item.lessons_grade_id)"
                />
              </q-btn-group>
              <q-btn
                round
                icon="more_vert"
                color="accent"
                class="mobile-only"
                outline
              >
                <q-menu>
                  <q-list style="min-width: 100px">
                    <q-item
                      clickable
                      v-close-popup
                      @click="store.getDetailLesson(item.lessons_grade_id)"
                    >
                      <q-item-section>{{ $t("perbarui") }}</q-item-section>
                    </q-item>
                    <q-separator />
                    <q-item
                      clickable
                      v-close-popup
                      @click="store.showDeleteConfirm(item.lessons_grade_id)"
                    >
                      <q-item-section>{{ $t("hapus") }}</q-item-section>
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
    <q-separator />
  </div>
</template>

<script>
import { computed } from "vue";
import { useRoute } from "vue-router";
import { usePagingStore } from "ss-paging-vue";
import { useScheduleStore } from "src/stores/schedule";
import { checkColWidth } from "src/composables/screen";

export default {
  name: "LessonsList",
  setup() {
    const store = useScheduleStore();
    const paging = usePagingStore();
    const route = useRoute();

    store.getLessonsList(route.params.id);

    return {
      store,
      data: computed(() => paging.state.data),
      checkColWidth,
    };
  },
};
</script>
