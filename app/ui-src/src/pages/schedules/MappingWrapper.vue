<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">
        {{ $t('jadwal_mapping') }} - {{ $store.state.schedule.className }}
      </div>
      <div class="text-h6 text-capitalize" v-else>
        {{ $t('jadwal_mapping') }} - {{ $store.state.schedule.className }}
      </div>
      <div :class="['row', titleSpacing()]">
        <mapping-button class="q-mt-sm" />
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
import MappingButton from './MappingButton.vue'
import MappingList from './MappingList.vue'

export default {
  name: 'MappingWrapper',
  components: {
    MappingButton,
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