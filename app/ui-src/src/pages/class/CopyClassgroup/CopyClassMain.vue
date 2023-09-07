<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="row">
        <q-btn
          color="teal"
          flat
          rounded
          class="back-button"
          icon="arrow_back"
          @click="$router.push('/class')"
        />
        <div
          class="text-subtitle1 text-uppercase q-mt-xs page-title-pl-5"
          v-if="$q.screen.lt.sm"
        >
          {{ $t('kelas_salin_rombel') }}
        </div>
        <div class="text-h6 text-capitalize" v-else>
          {{ $t('kelas_salin_rombel') }}
        </div>
      </div>
      <div :class="['row', titleSpacing()]">
        <div class="col-12 col-md-4">
          <q-btn
            icon="add"
            :class="['q-pl-sm mobile-hide', addButton]"
            unelevated
            :label="$t('kelas_apply_copy')"
            @click="selectClass"
          />
        </div>
        <row-dropdown class="q-mt-sm" />
        <search-box :label="$t('kelas_cari')" class="q-mt-sm" />
      </div>
    </q-card-section>
    <!-- DataTable -->
    <previous-class-table />
  </q-card>
</template>

<script setup>
import { useI18n } from 'vue-i18n'
import { computed } from 'vue'
import { useQuasar } from 'quasar'
import { useClassStore } from 'src/stores/class'
import { titleSpacing } from 'src/composables/screen'
import { addButton, flashAlert } from 'src/composables/common'
import PreviousClassTable from './PreviousClassTable.vue'

const { t } = useI18n()
const store = useClassStore()
const $q = useQuasar()

const selectClass = () => {
  if (store.selectedClasses.length > 0) {
    store.confirmCopyClass()
  } else {
    flashAlert(t('kelas_pilih_kelas_dulu'), 'negative')
  }
}
</script>
