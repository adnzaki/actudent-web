<template>
  <div class="q-mt-lg">
    <q-scroll-area class="table-scroll-area">
      <q-markup-table bordered>
        <thead>
          <tr>
            <th :class="['text-left cursor-pointer', checkColWidth()]">
              <q-checkbox v-model="$store.state.presence.checkAll" @update:model-value="selectAll" />
            </th>
            <th class="text-left">{{ $t('siswa_nama') }}</th>
            <th class="text-left">Status</th>
            <th class="text-left mobile-hide">{{ $t('aksi') }}</th>
            <th class="text-left mobile-hide">{{ $t('absensi_keterangan') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in presenceList" :key="index">
            <td :class="['text-left', checkColWidth()]"><q-checkbox v-model="$store.state.presence.studentPresence" :val="item.id" /></td>
            <td class="text-left">{{ item.name }}</td>
            <td class="text-left">
              <div v-if="item.statusID !== ''">
                <q-badge :color="presenceStatus(item.statusID)">{{ item.status }}</q-badge>
              </div>
              <div v-else>{{ item.status }}</div>
            </td>
            <td class="text-left mobile-hide">
              <q-btn-group v-if="presenceButtons">
                <q-btn color="accent" icon="done" @click="savePresence(1, item.id)"><btn-tooltip :label="$t('absensi_hadir')" /></q-btn>
                <q-btn color="accent" icon="health_and_safety" @click="savePresence(3, item.id)"><btn-tooltip :label="$t('absensi_sakit')" /></q-btn>
                <q-btn color="accent" icon="error_outline" @click="showPermissionForm(item.id)"><btn-tooltip :label="$t('absensi_izin')" /></q-btn>
                <q-btn color="accent" icon="not_interested" @click="savePresence(0, item.id)"><btn-tooltip :label="$t('absensi_alfa')" /></q-btn>
              </q-btn-group>
              <p v-else>-</p>
            </td> 
            <td class="text-left mobile-hide">{{ item.note }}</td>
          </tr>
        </tbody>
      </q-markup-table>
    </q-scroll-area>
    <q-separator/>
  </div>
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'
import { checkColWidth } from 'src/composables/screen'

export default {
  name: 'PresenceTable',
  setup () {
    const store = useStore()

    const selectAll = () => store.commit('presence/selectAll')

    const savePresence = (status, studentId) => {
      store.dispatch('presence/savePresence', { status, studentId })
    }

    const presenceStatus = status => {
      const colors = [
        'negative',
        'positive',
        'info',
        'orange'
      ]

      return colors[status]
    }

    const showPermissionForm = id => {
      store.state.presence.studentPresence = [ id ]
      store.state.presence.showPermissionForm = true
    }

    return {
      checkColWidth,
      selectAll,
      presenceList: computed(() => store.state.presence.presenceList),
      presenceButtons: computed(() => store.state.presence.presenceButtons),
      savePresence,
      presenceStatus,
      showPermissionForm
    }
  }
}
</script>