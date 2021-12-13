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
        <lessons-button class="q-mt-sm" />
      </div>
    </q-card-section>
  </q-card>
</template>

<script>
import { onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { useStore } from 'vuex'
import { titleSpacing } from 'src/composables/screen'

export default {
  name: 'MappingWrapper',
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