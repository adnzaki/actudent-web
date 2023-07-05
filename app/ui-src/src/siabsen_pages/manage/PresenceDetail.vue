<template>
  <q-dialog
    no-backdrop-dismiss
    v-model="store.showPresenceDetail"
    @hide="store.showPresenceDetail = false"
    :maximized="maximizedDialog()"
  >
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">
          {{ $t('siabsen_detail_absensi') }}
        </div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section :class="photoWrapper.cardSection">
        <q-img
          :src="imgSrc(store.inPhotoURL)"
          :style="imgSize"
          class="rounded-borders q-mr-md q-mt-md"
          fit="cover"
        >
          <div class="absolute-bottom text-subtitle1 text-center">
            {{ $t('siabsen_in') }}
          </div>
        </q-img>
        <q-img
          :src="imgSrc(store.outPhotoURL)"
          :style="imgSize"
          :class="photoWrapper.imgOut"
          fit="cover"
        >
          <div class="absolute-bottom text-subtitle1 text-center">
            {{ $t('siabsen_out') }}
          </div>
        </q-img>
        <!-- content -->
      </q-card-section>
      <q-separator v-if="!$q.screen.lt.sm" />
      <q-card-actions align="right" v-if="!$q.screen.lt.sm">
        <q-btn flat :label="$t('tutup')" color="negative" v-close-popup />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { maximizedDialog, cardDialog } from 'src/composables/screen'
import { useQuasar } from 'quasar'
import { computed, ref } from 'vue'
import { useSiabsenStore } from 'src/stores/siabsen'

export default {
  setup() {
    const $q = useQuasar()
    const imgSize = computed(() => {
      let defaultStyle = {
        width: '300px',
        height: '400px',
      }

      if ($q.screen.lt.md) {
        defaultStyle = {
          width: '290px',
          height: '387px',
        }
      }

      if ($q.screen.lt.sm) {
        defaultStyle = {
          width: '310px',
          height: '413px',
        }
      }

      return defaultStyle
    })

    const photoWrapper = ref({
      cardSection: $q.screen.lt.sm ? 'card-section' : 'scroll card-section',
      imgOut: $q.screen.lt.sm
        ? 'rounded-borders q-mt-md q-mb-lg'
        : 'rounded-borders q-mt-md',
    })

    return {
      store: useSiabsenStore(),
      photoWrapper,
      maximizedDialog,
      imgSize,
      imgSrc: (src) =>
        src !== '' && src !== '-'
          ? src
          : require('../../../public/no-image.png'),
      cardDialog,
    }
  },
}
</script>
