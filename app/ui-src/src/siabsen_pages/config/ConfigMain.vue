<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">
        {{ $t('siabsen_config_absensi') }}
      </div>
      <div class="text-h6 text-capitalize" v-else>
        {{ $t('siabsen_config_absensi') }}
      </div>
    </q-card-section>

    <div :class="['q-pb-md', formPx()]" style="margin-top: -20px">
      <config-form />
    </div>
  </q-card>
</template>

<script>
import { useQuasar } from 'quasar'
import { titleSpacing } from 'src/composables/screen'
import ConfigForm from './ConfigForm.vue'

export default {
  components: { ConfigForm },
  setup() {
    const $q = useQuasar()

    return {
      formPx() {
        // padding X (horizontal)
        return $q.screen.lt.sm ? '' : 'q-px-lg'
      },
      titleSpacing,
    }
  },
}
</script>
