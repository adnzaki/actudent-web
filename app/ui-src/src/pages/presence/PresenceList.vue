<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">
        {{ pageTitle }}
      </div>
      <div class="text-h6 text-capitalize" v-else>
        {{ pageTitle }}
      </div>
      <div :class="['row', titleSpacing()]">
        <main-button class="q-mt-sm" />
      </div>
    </q-card-section>
    <!-- <mapping-list /> -->
  </q-card>
</template>

<script>
import { useRoute } from 'vue-router'
import { useStore } from 'vuex'
import { useI18n } from 'vue-i18n'
import { titleSpacing } from 'src/composables/screen'
import MainButton from './MainButton.vue'

export default {
  name: 'PresenceList',
  components: {
    MainButton
  },
  setup() {
    
    const route = useRoute()
    const store = useStore()
    const { t } = useI18n()

    return {
      pageTitle: `${t('absensi_title')} - ${store.state.presence.className}`,
      titleSpacing
    }
  }
}
</script>