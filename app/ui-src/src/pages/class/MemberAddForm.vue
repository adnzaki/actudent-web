<template>
  <q-dialog
    no-backdrop-dismiss
    v-model="store.classMember.showForm"
    @before-show="formOpen"
    :maximized="maximizedDialog()"
    @hide="store.getClassMember($route.params.id)"
  >
    <q-card :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">
          {{ $t("kelas_add_student_to_group") }}
        </div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="card-section">
        <search-box :label="$t('kelas_group_member_search')" />
        <q-scroll-area class="in-form-scroll-area">
          <q-markup-table bordered>
            <thead>
              <tr>
                <th
                  :class="[
                    'text-left cursor-pointer mobile-hide',
                    checkColWidth(),
                  ]"
                >
                  #
                </th>
                <th class="text-left cursor-pointer mobile-hide">
                  {{ $t("siswa_nis") }}
                </th>
                <th
                  class="text-left cursor-pointer"
                  @click="paging.sortData('student_name')"
                >
                  {{ $t("siswa_nama") }} <sort-icon />
                </th>
                <th class="text-left">{{ $t("aksi") }}</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in data" :key="index">
                <td :class="['text-left mobile-hide', checkColWidth()]">
                  {{ index + 1 }}
                </td>
                <td class="text-left mobile-hide">{{ item.student_nis }}</td>
                <td class="text-left">{{ item.student_name }}</td>
                <td class="text-left">
                  <q-btn
                    color="deep-purple"
                    icon="add"
                    @click="addMember(item.student_id)"
                  >
                    <q-tooltip
                      anchor="top middle"
                      self="center middle"
                      :offset="[10, 10]"
                    >
                      {{ $t("kelas_add_member_title") }}
                    </q-tooltip>
                  </q-btn>
                </td>
              </tr>
            </tbody>
          </q-markup-table>
        </q-scroll-area>
        <q-separator />

        <ss-paging :store="store" />
      </q-card-section>
      <q-separator />
      <q-card-actions align="right">
        <q-btn
          flat
          :label="$t('tutup')"
          v-if="!$q.screen.lt.sm"
          color="negative"
          v-close-popup
        />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { computed } from "vue";
import { useRoute } from "vue-router";
import { usePagingStore } from "ss-paging-vue";
import { useClassStore } from "src/stores/class";
import {
  maximizedDialog,
  cardDialog,
  checkColWidth,
} from "../../composables/screen";

export default {
  name: "MemberAddForm",
  setup() {
    const store = useClassStore();
    const paging = usePagingStore();
    const route = useRoute();

    const formOpen = () => {
      store.getUnregisteredStudents(route.params.id);
    };

    const addMember = (id) => {
      store.addToClassGroup({
        id,
        grade: route.params.id,
      });
    };

    return {
      store,
      paging,
      data: computed(() => paging.state.data),
      checkColWidth,
      maximizedDialog,
      cardDialog,
      formOpen,
      addMember,
    };
  },
};
</script>
