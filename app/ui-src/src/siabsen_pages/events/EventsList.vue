<template>
  <div>
    <q-scroll-area class="no-paging-scroll-area">
      <q-markup-table bordered>
        <thead>
          <tr>
            <th class="text-center cursor-pointer">#</th>
            <th class="text-left">{{ $t('tanggal') }}</th>
            <th class="text-left">{{ $t('agenda_label_nama') }}</th>
            <th class="text-left">{{ $t('jadwal_waktu') }}</th>
            <th class="text-left">{{ $t('aksi') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in userEvents" :key="index">
            <td class="text-center">{{ index + 1 }}</td>
            <td class="text-left">{{ item.date }}</td>
            <td class="text-left">{{ item.name }}</td>
            <td class="text-left">{{ item.time }}</td>
            <td class="text-left">
              <q-btn-group>
                <q-btn color="accent" icon="touch_app">
                  <btn-tooltip :label="$t('siabsen_do_absen')" />
                </q-btn>
                <q-btn color="accent" icon="o_info" @click="$store.dispatch('agenda/getDetail', item.id)">
                  <btn-tooltip :label="$t('agenda_detail_title')" />
                </q-btn>
              </q-btn-group>
            </td>
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
  setup () {
    const store = useStore()

    return {
      userEvents: computed(() => store.state.siabsen.userEvents),
      checkColWidth,
    }
  }
}
</script>