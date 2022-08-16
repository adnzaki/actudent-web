<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ $t('siabsen_kegiatan') }}</div>
      <div class="text-h6 text-capitalize" v-else>{{ $t('siabsen_kegiatan') }}</div>
      <div :class="['row', titleSpacing()]" style="margin-top: 0;">

      </div>
    </q-card-section>
    <!-- content here -->
  </q-card>
</template>

<script>
import { useStore } from 'vuex'
import { titleSpacing } from 'src/composables/screen'

export default {
  setup() {
    return {
      titleSpacing
    }
  }
}
</script>