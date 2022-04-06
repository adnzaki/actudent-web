<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="row">
        <q-btn color="teal" flat rounded
          class="back-button"
          icon="arrow_back" 
          @click="$router.push('/schedules')" />
        <div class="text-subtitle1 text-uppercase q-mt-xs page-title-pl-5" v-if="$q.screen.lt.sm">
          {{ $t('jadwal_mapping') }}
        </div>
        <div class="text-h6 text-capitalize" v-else>
          {{ $t('jadwal_mapping') }} - {{ $store.state.schedule.className }}
        </div>
      </div>
      <div :class="['row', titleSpacing()]">
      </div>
    </q-card-section>
    <mapping-list />
  </q-card>
</template>

<script>
import { onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { useStore } from 'vuex'
import { titleSpacing } from 'src/composables/screen'
import MappingList from './MappingList.vue'

export default {
  name: 'MappingWrapper',
  components: {
    MappingList
  },
  setup() {
    const route = useRoute()
    const store = useStore()

    onMounted(() => {
      
    })

    return {
      titleSpacing
    }
  }
}
</script>