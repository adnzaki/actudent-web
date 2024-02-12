<template>
  <q-card class="my-card" v-if="store.sessions !== null">
    <q-card-section class="q-mb-md">
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">
        {{ $t('session_manager') }}
      </div>
      <div class="text-h6 text-capitalize" v-else>
        {{ $t('session_manager') }}
      </div>
      <!-- <div :class="['row', titleSpacing()]">
        <row-dropdown
          root-class="col-12 col-md-2"
          :options="[5, 10, 15, 20, 25]"
          class="q-mt-sm"
        />
      </div> -->
    </q-card-section>
    <session-list />
  </q-card>
</template>

<script>
import { titleSpacing } from 'src/composables/screen'
import SessionList from './SessionList.vue'
import { useSessionStore } from 'src/stores/sessions'

export default {
  name: 'SessionMain',
  components: {
    SessionList,
  },
  setup() {
    return {
      store: useSessionStore(),
      titleSpacing,
    }
  },
}
</script>
