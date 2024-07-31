<template>
  <div :class="wrapperPadding()">
    <q-card class="my-card">
      <q-card-section>
        <div class="row">
          <div
            :class="['text-subtitle1 text-uppercase q-mt-xs', pushLeft]"
            v-if="$q.screen.lt.sm"
          >
            {{ $t('presence_detail') }}
          </div>
          <div class="text-h6 text-capitalize" v-else>
            {{ $t('presence_detail') }}
          </div>
        </div>
        <div :class="['row q-mt-md', titleSpacing()]">
          <presence-selector />
        </div>
      </q-card-section>
      <div class="q-pa-md summary-spinner" v-if="store.showSpinner">
        <q-spinner-bars color="purple" size="xl" />
      </div>
      <presence-list />
    </q-card>
  </div>
</template>

<script setup>
import { useQuasar } from 'quasar'
import { titleSpacing, wrapperPadding } from 'src/composables/screen'
import PresenceSelector from './PresenceSelector.vue'
import PresenceList from './PresenceList.vue'
import { useMonitoringStore } from 'src/stores/monitoring.js'

const store = useMonitoringStore()
const $q = useQuasar()

const pushLeft = $q.screen.lt.sm ? '' : 'page-title-pl-5'
</script>
