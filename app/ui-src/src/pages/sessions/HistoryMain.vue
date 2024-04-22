<template>
  <q-card class="my-card">
    <q-card-section class="q-mb-md">
      <div class="row">
        <q-btn
          color="teal"
          flat
          rounded
          class="back-button"
          icon="arrow_back"
          @click="$router.push('/manage-account')"
          v-if="$q.screen.lt.sm && store.sessions === null"
        />
        <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">
          {{ $t('login_history') }}
        </div>
        <div class="text-h6 text-capitalize" v-else>
          {{ $t('login_history') }}
        </div>
      </div>
      <div :class="['row', titleSpacing()]">
        <row-dropdown
          root-class="col-12 col-md-2"
          :options="[5, 10, 15, 20, 25]"
          class="q-mt-sm"
        />
      </div>
    </q-card-section>
    <history-list />
  </q-card>
</template>

<script>
import { titleSpacing } from 'src/composables/screen'
import HistoryList from './HistoryList.vue'
import { useSessionStore } from 'src/stores/sessions'

export default {
  name: 'HistoryMain',
  components: {
    HistoryList,
  },
  setup() {
    return {
      store: useSessionStore(),
      titleSpacing,
    }
  },
}
</script>
