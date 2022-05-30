<template>
  <q-dialog v-model="$store.state.siabsen.showPresenceDialog" 
    @show="openCamera"
    @before-hide="stopVideo">
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ $t('siabsen_kehadiran') }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">    

          <div class="row">
            <div class="col-12">
              <div id="myVideo">
                <video ref="video" autoplay v-if="showVideo" style="width: 100%;">Video tidak tersedia</video>
              </div>
              <canvas ref="canvas" width="480" height="640" style="display: none"></canvas>
              <img :src="imgSrc" />
            </div>
          </div>

        </q-form>
      </q-card-section>
      <q-separator />
      <q-card-actions align="right">
        <q-btn flat :label="$t('tutup')" color="negative" v-close-popup />
        <q-btn :label="$t('siabsen_ambil_gambar')" 
          @click="takePicture" v-if="canTakePicture" 
          color="primary" padding="8px 20px" />
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
    const video = ref(null)
    const canvas = ref(null)
    const openCamera = ref(null)
    const takePicture = ref(null)
    const stopVideo = ref(null)
    const showVideo = ref(false)
    const imgSrc = ref('')
    const locationDescription = ref('')
    const mapsURL = ref('')
    const canTakePicture = ref(false)
    const validationStatus = ref('')
    const location = ref({})

    const locationOptions = {
      enableHighAccuracy: true,
      timeout: 5000,
      maximumAge: 0
    }

    const getLocationSuccess = pos => {
      const crd = pos.coords
      if(crd.accuracy > 100) {
        const notifyAccuracy = $q.notify({
          group: true,
          message: t('siabsen_tidak_akurat'),
          color: 'negative',
          position: 'center',
          timeout: 3000,
          actions: [
            { label: 'X', color: 'white', handler: () => { /* ... */ } }
          ]
        })
      }
      const crdData = {
        lat: crd.latitude,
        long: crd.longitude
      }

      location.value = crdData

      axios.post(`${conf.siabsenAPI}validate-position`, crdData, {
        headers: { Authorization: bearerToken },
        transformRequest: [data => {
          return createFormData(data)
        }]
      })
        .then(({ data }) => {
          if(data.code === 500) {
            canTakePicture.value = false
            const notifyPosition = $q.notify({
              group: true,
              message: data.msg,
              color: 'negative',
              position: 'center',
              timeout: 0,
              actions: [
                { 
                  label: t('siabsen_cek_posisi'), color: 'white', handler: () => {
                    window.open(`https://www.google.com/maps/@${crd.latitude},${crd.longitude},15z`, '_blank')
                  } 
                }
              ]
            })
          } else if(data.code === 200) {
            canTakePicture.value = true
          }
        })
    }

    const getLocationError = err => locationDescription.value = `${err.code}: ${err.message}`

    onMounted(() => {
      openCamera.value = () => { 
          showVideo.value = true
          navigator.geolocation.watchPosition(getLocationSuccess, getLocationError, locationOptions)
          navigator.mediaDevices.getUserMedia({ video: true }).then(stream => {
            video.value.srcObject = stream
          })
      }      

      stopVideo.value = () => {
        video.value.srcObject.getVideoTracks().forEach(track => track.stop())
        showVideo.value = false
        // store.state.siabsen.showPresenceDialog = false
      }

      takePicture.value = () => {
        const context = canvas.value.getContext('2d')
        
        context.drawImage(video.value, 0, 0, canvas.value.width, canvas.value.height);
        // imgSrc.value = canvas.value.toDataURL('image/jpeg')
        store.dispatch('siabsen/pushPresence', {
          lat: location.value.lat,
          long: location.value.long
        })
      }

      const presenceSuccess = computed(() => store.state.siabsen.presenceSuccess)
      watch(presenceSuccess, () => {
        if(store.state.siabsen.presenceSuccess) {
          stopVideo.value()
          store.state.siabsen.showPresenceDialog = false
        }
      })
    })
    

    return {
      stopVideo,
      canTakePicture,
      validationStatus,
      mapsURL,
      locationDescription,
      imgSrc,
      showVideo,
      takePicture,
      openCamera,
      video,
      canvas,
      cardDialog
    }
  }
}
</script>