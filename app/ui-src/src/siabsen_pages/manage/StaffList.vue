<template>
  <div>
    <q-scroll-area class="table-scroll-area">
      <q-markup-table bordered>
        <thead>
          <tr>
            <th class="text-center cursor-pointer">#</th>
            <th class="text-left cursor-pointer mobile-hide">{{ $t('staff_id') }}</th>
            <th class="text-left cursor-pointer">{{ $t('staff_nama') }}</th>
            <th class="text-left cursor-pointer mobile-hide">{{ $t('siabsen_in') }}</th>
            <th class="text-left cursor-pointer mobile-hide">{{ $t('siabsen_out') }}</th>
            <th class="text-left">{{ $t('aksi') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td class="text-center">{{ $store.getters['siabsen/itemNumber'](index) }}</td>
            <td class="text-left mobile-hide">{{ item.nip }}</td>
            <td class="text-left mobile-only">{{ $trim(item.name, 30) }}</td>
            <td class="text-left mobile-hide">{{ item.name }}</td>
            <td class="text-left mobile-hide">{{ item.in }}</td>
            <td class="text-left mobile-hide">{{ item.out }}</td>
            <td class="text-left">
              <!-- <q-btn-group class="mobile-hide">
                <q-btn color="accent" icon="list" @click="showLessons(item.grade_id, item.grade_name)" />
                <q-btn color="accent" icon="menu_book" @click="showSchedules(item.grade_id, item.grade_name)" />
              </q-btn-group>
              <q-btn round icon="more_vert" color="accent" class="mobile-only" outline>
                <q-menu>
                  <q-list style="min-width: 200px">
                    <q-item clickable v-close-popup @click="showLessons(item.grade_id, item.grade_name)">
                      <q-item-section>{{ $t('jadwal_daftar_mapel') }}</q-item-section>
                    </q-item>
                    <q-separator />
                    <q-item clickable v-close-popup @click="showSchedules(item.grade_id, item.grade_name)">
                      <q-item-section>{{ $t('jadwal_jadwal_mapel') }}</q-item-section>
                    </q-item>
                    <q-separator />
                  </q-list>
                </q-menu>
              </q-btn> -->
            </td>
          </tr>
        </tbody>
      </q-markup-table>
    </q-scroll-area>
    <q-separator/>
    <ss-paging vuex-module="siabsen" />
  </div>
</template>

<script>
import { useRouter } from 'vue-router'
import { useStore } from 'vuex'
import { checkColWidth } from 'src/composables/screen'
import { computed } from 'vue'

export default {
  name: 'StaffList',
  setup () {
    const router = useRouter()
    const store = useStore()

    return {
      data: computed(() => store.state.siabsen.paging.data),
      checkColWidth,
    }
  }
}
</script>