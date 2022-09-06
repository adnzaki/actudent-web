<template>
  <div class="q-pa-md">
    <q-input dense filled class="q-mb-sm" 
      :label="$t('agenda_search_name')"
      v-model="search"
      @update:model-value="filterName" />
    
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
    <ss-paging vuex-module="siabsen" />
  </div>
</template>

<script>
import { computed, ref, watch } from 'vue'
import { useStore } from 'vuex'
import { useRoute } from 'vue-router'


export default {
  setup () {
    const store = useStore()
    const route = useRoute()

    const data = computed(() => store.state.siabsen.paging.data)

    const search = ref('')
    watch(search, () => {
      if(search.value === '') {
        store.dispatch('siabsen/getAttendance', route.params.agendaId)
      }
    })

    const filterName = (query) => {
      const newData = data.value.filter(item => {
        return item.name.toLowerCase().includes(query.toLowerCase())
      })

      store.state.siabsen.paging.data = newData
    }

    return {
      filterName,
      search,
      data
    }
  }
}
</script>