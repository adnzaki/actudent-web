<template>
  <div class="q-pa-md">
    <q-input
      dense
      filled
      class="q-mb-sm"
      :label="$t('agenda_search_name')"
      v-model="search"
      @update:model-value="filterName"
    />

    <q-list bordered separator>
      <q-item clickable v-ripple v-for="(item, index) in data" :key="index">
        <q-item-section>
          <q-item-label>{{ item.name }}</q-item-label>
          <q-item-label caption>
            {{ $t('siabsen_present_time') }}:
            {{ item.time }}
          </q-item-label>
        </q-item-section>
        <q-item-section side top>
          <q-badge color="teal" :label="item.type" />
        </q-item-section>
      </q-item>
    </q-list>
    <ss-paging v-model="store.current" />
  </div>
</template>

<script>
import { computed, ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import { usePagingStore } from 'ss-paging-vue'
import { useSiabsenStore } from 'src/stores/siabsen'

export default {
  setup() {
    const store = useSiabsenStore()
    const paging = usePagingStore()
    const route = useRoute()

    const data = computed(() => paging.state.data)

    const search = ref('')
    watch(search, () => {
      if (search.value === '') {
        store.getAttendance(route.params.agendaId)
      }
    })

    const filterName = (query) => {
      const newData = data.value.filter((item) => {
        return item.name.toLowerCase().includes(query.toLowerCase())
      })

      paging.state.data = newData
    }

    return {
      store,
      filterName,
      search,
      data,
    }
  },
}
</script>
