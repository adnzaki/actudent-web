<template>
  <div class="col-12">
    <div class="q-gutter-xs">
      <q-btn color="deep-purple" icon="add" 
        class="q-pl-sm mobile-hide" :label="$t('tambah')"
        @click="showForm"
      />
    </div>

    <q-page-sticky position="bottom-right" 
      :offset="fabPos" 
      class="mobile-only force-elevated">
      <q-btn fab icon="add" color="deep-purple" 
        @click="showForm" 
      />
    </q-page-sticky>
  </div>
</template>

<script>
import { fabPos } from 'src/composables/fab'
import { useQuasar } from 'quasar'
import { useI18n } from 'vue-i18n'
import { useStore } from 'vuex'
import { useRouter, useRoute } from 'vue-router'
import { computed } from 'vue'
import { conf } from 'src/composables/common'

export default {
  name: 'MainButton',
  setup() {
    const $q = useQuasar()
    const { t } = useI18n()
    const router = useRouter()
    const route = useRoute()
    const store = useStore()

    return {
      showForm: () => store.state.siabsen.showPermitForm = true,
      fabPos,
    }
  }
}
</script>