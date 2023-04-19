<template>
  <div>
    <q-scroll-area class="table-scroll-area">
      <q-markup-table bordered>
        <thead>
          <tr>
            <th class="text-center cursor-pointer">#</th>
            <th
              class="text-left cursor-pointer"
              @click="paging.sortData('grade_name')"
            >
              {{ $t('kelas_nama') }} <sort-icon />
            </th>
            <th
              class="text-left cursor-pointer mobile-hide"
              @click="paging.sortData('staff_name')"
            >
              {{ $t('kelas_wali') }} <sort-icon />
            </th>
            <th class="text-left cursor-pointer mobile-hide">
              {{ $t('kelas_tahun') }}
            </th>
            <th class="text-left">{{ $t('aksi') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td class="text-center">{{ paging.itemNumber(index) }}</td>
            <td class="text-left mobile-hide">{{ item.grade_name }}</td>
            <td class="text-left mobile-only">
              {{ $trim(item.grade_name, 30) }}
            </td>
            <td class="text-left mobile-hide">{{ item.staff_name }}</td>
            <td class="text-left mobile-hide">
              {{ item.period_start }} / {{ item.period_end }}
            </td>
            <td class="text-left">
              <q-btn-group class="mobile-hide">
                <q-btn
                  color="accent"
                  icon="fact_check"
                  @click="
                    presenceAction(item.grade_id, item.grade_name, 'fill')
                  "
                >
                  <btn-tooltip :label="$t('absensi_isi_kehadiran')" />
                </q-btn>
                <q-btn
                  color="accent"
                  icon="date_range"
                  @click="
                    presenceAction(
                      item.grade_id,
                      item.grade_name,
                      'monthly-summary'
                    )
                  "
                >
                  <btn-tooltip :label="$t('absensi_rekap_bulanan')" />
                </q-btn>
                <q-btn
                  color="accent"
                  icon="insert_chart_outlined"
                  @click="
                    presenceAction(
                      item.grade_id,
                      item.grade_name,
                      'period-summary'
                    )
                  "
                >
                  <btn-tooltip :label="$t('absensi_rekap_semester')" />
                </q-btn>
              </q-btn-group>
              <q-btn
                round
                icon="more_vert"
                color="accent"
                class="mobile-only"
                outline
              >
                <q-menu>
                  <q-list style="min-width: 150px">
                    <q-item
                      clickable
                      v-close-popup
                      @click="
                        presenceAction(item.grade_id, item.grade_name, 'fill')
                      "
                    >
                      <q-item-section>{{
                        $t('absensi_isi_kehadiran')
                      }}</q-item-section>
                    </q-item>
                    <q-separator />
                    <q-item
                      clickable
                      v-close-popup
                      @click="
                        presenceAction(
                          item.grade_id,
                          item.grade_name,
                          'monthly-summary'
                        )
                      "
                    >
                      <q-item-section>{{
                        $t('absensi_rekap_bulanan')
                      }}</q-item-section>
                    </q-item>
                    <q-item
                      clickable
                      v-close-popup
                      @click="
                        presenceAction(
                          item.grade_id,
                          item.grade_name,
                          'period-summary'
                        )
                      "
                    >
                      <q-item-section>{{
                        $t('absensi_rekap_semester')
                      }}</q-item-section>
                    </q-item>
                  </q-list>
                </q-menu>
              </q-btn>
            </td>
          </tr>
        </tbody>
      </q-markup-table>
    </q-scroll-area>
    <q-separator />
    <ss-paging v-model="store.current" />
  </div>
</template>

<script>
import { computed } from 'vue'
import { useRouter } from 'vue-router'
import { usePagingStore } from 'ss-paging-vue'
import { useClassStore } from 'src/stores/class'
import { usePresenceStore } from 'src/stores/presence'
import { checkColWidth } from 'src/composables/screen'

export default {
  name: 'ClassTable',
  setup() {
    const store = usePresenceStore()
    const classStore = useClassStore()
    const paging = usePagingStore()
    const router = useRouter()

    setTimeout(() => {
      classStore.getClassList()
    }, 500)

    const presenceAction = (id, name, url) => {
      store.className = name
      localStorage.setItem('class', name)
      router.push(`/presence/${url}/${id}`)
    }

    return {
      store,
      paging,
      data: computed(() => paging.state.data),
      checkColWidth,
      presenceAction,
    }
  },
}
</script>
