<template>
  <q-card class="my-card" v-if="store.sessions !== null">
    <q-card-section class="q-mb-md">
      <div class="row">
        <q-btn
          color="teal"
          flat
          rounded
          class="back-button"
          icon="arrow_back"
          @click="$router.push('/manage-account')"
          v-if="$q.screen.lt.sm"
        />
        <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">
          {{ $t('session_manager') }}
        </div>
        <div class="text-h6 text-capitalize" v-else>
          {{ $t('session_manager') }}
        </div>
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
    <delete-confirm
      :store="store"
      :custom-text="$t('session_delete_confirm')"
      @action="store.deleteSession()"
    />
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
