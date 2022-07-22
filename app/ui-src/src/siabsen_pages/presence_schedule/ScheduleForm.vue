<template>
  <q-dialog v-model="$store.state.siabsen.showScheduleForm"
    :maximized="maximizedDialog()">
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">
          {{ $t('siabsen_atur_jadwal') }}
          {{ $store.state.siabsen.staffName }}
        </div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>
    </q-card>
  </q-dialog>
</template>

<script>
import { maximizedDialog, cardDialog } from 'src/composables/screen'

export default {
  setup() {
    return {
      maximizedDialog, cardDialog
    }
  }
}
</script>