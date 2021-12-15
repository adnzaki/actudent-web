<template>
  <div class="col-12 col-sm-4 q-px-md">
    <q-card class="my-card q-mb-sm">
      <q-card-section>
        <div class="text-h6">{{ day }}</div>
      </q-card-section>

      <q-separator />

      <p class="text-center text-bold q-mt-md" v-if="schedules[target] === undefined || schedules[target].length === 0">
        {{ $t('jadwal_list_kosong') }} 
      </p>

      <q-list padding bordered class="rounded-borders" v-else>
        <q-expansion-item
          dense-toggle
          expand-separator
          v-for="(item, index) in schedules[target]" :key="index"
          :label="item.lesson_name"
          :header-class="listItemClass(item.lesson_code)"
          :expand-icon-class="expandIconClass(item.lesson_code)"
        >
          <q-card class="bg-blue-grey-1">
            <q-card-section>
              <q-markup-table dense separator="none">
                <tbody>
                  <tr>
                    <td>{{ $t('jadwal_durasi') }}</td>
                    <td>
                      : {{ item.duration }}
                      <span v-if="item.lesson_code === 'REST'"> {{ $t('jadwal_menit') }} </span>
                      <span v-else> {{ $t('jadwal_jam_pelajaran') }} </span>
                    </td>
                  </tr>
                  <tr>
                    <td>{{ $t('jadwal_waktu') }}</td><td>: {{ item.schedule_start }} - {{ item.schedule_end }}</td>
                  </tr>
                  <tr v-if="item.lesson_code !== 'REST'">
                    <td>{{ $t('jadwal_guru_mapel') }}</td><td>: {{ item.teacher }}</td>
                  </tr>
                </tbody>
              </q-markup-table>
            </q-card-section>
          </q-card>
        </q-expansion-item>
      </q-list>

      <q-card-actions vertical>
        <q-btn color="accent" @click="$store.commit('schedule/showMappingForm', target)">{{ $t('kelola') }}</q-btn>
      </q-card-actions>

    </q-card>
  </div>
</template>

<script>
import { mapState } from 'vuex'
export default {
  name: 'MappingDay',
  props: ['day', 'target'],
  computed: {
    ...mapState('schedule', {
      schedules: state => state.schedule.list,
    })
  },
  setup() {
    const listItemClass = code => {
      return code === 'REST' ? 'bg-teal text-white text-bold' : ''
    }

    const expandIconClass = code => {
      return code === 'REST' ? 'text-white' : ''
    }

    return {
      listItemClass,
      expandIconClass
    }
  }
}
</script>
