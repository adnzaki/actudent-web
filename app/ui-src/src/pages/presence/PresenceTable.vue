<template>
  <div :class="btnAndTableDistance">
    <q-scroll-area :class="scrollArea">
      <q-markup-table bordered wrap-cells>
        <thead>
          <tr>
            <th :class="['text-left cursor-pointer', checkColWidth()]">
              <q-checkbox
                v-model="store.checkAll"
                @update:model-value="store.selectAll()"
              />
            </th>
            <th class="text-left">{{ $t('siswa_nama') }}</th>
            <th class="text-left">Status</th>
            <th class="text-left mobile-hide">{{ $t('aksi') }}</th>
            <th class="text-left mobile-hide">
              {{ $t('absensi_keterangan') }}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in presenceList" :key="index">
            <td :class="['text-left', checkColWidth()]">
              <q-checkbox v-model="store.studentPresence" :val="item.id" />
            </td>
            <td class="text-left">{{ item.name }}</td>
            <td class="text-left">
              <div v-if="item.statusID !== ''">
                <q-badge :color="presenceStatus(item.statusID)">{{
                  item.status
                }}</q-badge>
              </div>
              <div v-else>{{ item.status }}</div>
            </td>
            <td class="text-left mobile-hide">
              <q-btn-group v-if="presenceButtons">
                <q-btn
                  class="action-btn"
                  icon="done"
                  @click="savePresence(1, item.id)"
                  ><btn-tooltip :label="$t('absensi_hadir')"
                /></q-btn>
                <q-btn
                  class="action-btn"
                  icon="health_and_safety"
                  @click="savePresence(3, item.id)"
                  ><btn-tooltip :label="$t('absensi_sakit')"
                /></q-btn>
                <q-btn
                  class="action-btn"
                  icon="error_outline"
                  @click="showPermissionForm(item.id)"
                  ><btn-tooltip :label="$t('absensi_izin')"
                /></q-btn>
                <q-btn
                  class="action-btn"
                  icon="not_interested"
                  @click="savePresence(0, item.id)"
                  ><btn-tooltip :label="$t('absensi_alfa')"
                /></q-btn>
              </q-btn-group>
              <p v-else>-</p>
            </td>
            <td class="text-left mobile-hide">{{ item.note }}</td>
          </tr>
        </tbody>
      </q-markup-table>
    </q-scroll-area>
    <q-separator />
  </div>
</template>

<script>
import { computed } from 'vue'
import { checkColWidth } from 'src/composables/screen'
import { usePresenceStore } from 'src/stores/presence'

export default {
  name: 'PresenceTable',
  setup() {
    const store = usePresenceStore()

    const savePresence = (status, studentId) => {
      store.savePresence({ status, studentId })
    }

    const presenceStatus = (status) => {
      const colors = ['negative', 'positive', 'info', 'orange']

      return colors[status]
    }

    const showPermissionForm = (id) => {
      store.studentPresence = [id]
      store.showPermissionForm = true
    }

    return {
      store,
      savePresence,
      checkColWidth,
      presenceStatus,
      showPermissionForm,
      presenceList: computed(() => store.presenceList),
      presenceButtons: computed(() => store.presenceButtons),
      btnAndTableDistance: store.isTeacherSection ? 'q-mt-sm' : 'q-mt-lg',
      scrollArea: store.isTeacherSection
        ? 'no-paging-scroll-area'
        : 'table-scroll-area',
    }
  },
}
</script>
