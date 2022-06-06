<template>
  <q-dialog v-model="$store.state.siabsen.showPresenceDetail"
    @hide="$store.state.siabsen.showPresenceDetail = false">
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ $t('siabsen_detail_absensi') }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-img 
          :src="imgSrc($store.state.siabsen.inPhotoURL)"
          style="max-width: 300px; height: 400px;"
          class="rounded-borders q-mr-md q-mt-md"
          fit="cover">
          <div class="absolute-bottom text-subtitle1 text-center">
            {{ $t('siabsen_in') }}
          </div>
        
        </q-img>
        <q-img 
          :src="imgSrc($store.state.siabsen.outPhotoURL)"
          style="max-width: 300px; height: 400px;"
          class="rounded-borders q-mt-md"
          fit="cover">
          <div class="absolute-bottom text-subtitle1 text-center">
            {{ $t('siabsen_out') }}
          </div>
        
        </q-img>
        <!-- content -->
      </q-card-section>
      <q-separator />
      <q-card-actions align="right">
        <q-btn flat :label="$t('tutup')" color="negative" v-close-popup />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { onMounted, ref, computed, watch } from 'vue'
import { axios, conf, createFormData, bearerToken, t } from 'src/composables/common'
import { cardDialog } from 'src/composables/screen'
import { useStore } from 'vuex'
import { useQuasar } from 'quasar'

export default {
  setup() { 
    const $q = useQuasar()
    const store = useStore()    

    return {
      imgSrc: src => src !== '' && src !== '-' ? src : require('../../../public/no-image.png'),
      cardDialog
    }
  }
}
</script>