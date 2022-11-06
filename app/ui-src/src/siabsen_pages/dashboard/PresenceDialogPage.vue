<template>
  <!-- <q-dialog v-model="$store.state.siabsen.showPresenceDialog" 
    @show="openCamera"
    @before-hide="stopVideo"
    :maximized="maximizedDialog()">
  </q-dialog> -->
  <q-card class="q-pa-sm">
    <q-card-section class="row items-center q-pb-none">
      <div class="row">
        <q-btn color="teal" flat rounded
          class="back-button"
          icon="arrow_back" 
          @click="$router.push('/teacher/home')" />
        <div class="text-subtitle1 text-uppercase q-mt-xs page-title-pl-5" v-if="$q.screen.lt.sm">
          {{ $t('kembali') }}
        </div>
        <div class="text-h6 text-capitalize" v-else>
          {{ $t('kembali') }}
        </div>
      </div>
    </q-card-section>

    <q-card-section class="scroll card-section">
      <q-form class="q-gutter-xs">    

        <div class="row">
          <div class="col-12">
            <div id="myVideo">
              <video ref="video" autoplay v-if="showVideo" style="width: 100%;">Video tidak tersedia</video>
            </div>
            <canvas ref="canvas" id="canvas" width="480" height="640" style="display: none"></canvas>
          </div>
        </div>

      </q-form>
    </q-card-section>
    <q-separator />
    <q-card-actions align="right">
      <q-btn flat v-if="!$q.screen.lt.sm" :label="$t('tutup')" color="negative" v-close-popup />
      <q-btn :label="$t('siabsen_ambil_gambar')" 
        @click="takePicture" 
        color="primary" padding="8px 20px"
        class="mobile-form-btn" />
    </q-card-actions>
  </q-card>
</template>

<script>
import { onMounted, ref, computed, watch } from 'vue'
import { axios, conf, createFormData, bearerToken, t } from 'src/composables/common'
import { maximizedDialog, cardDialog } from 'src/composables/screen'
import { useStore } from 'vuex'
import { useQuasar } from 'quasar'
import { useRouter } from 'vue-router'

export default {
  setup() {
    const $q = useQuasar()
    const store = useStore()
    const router = useRouter()
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

    const getLocationError = err => locationDescription.value = `${err.code}: ${err.message}`

    onMounted(() => {
      openCamera.value = () => { 
        showVideo.value = true
        navigator.mediaDevices.getUserMedia({ video: true }).then(stream => {
          video.value.srcObject = stream
        })
      }  
      
      openCamera.value()

      stopVideo.value = () => {
        video.value.srcObject.getVideoTracks().forEach(track => track.stop())
        showVideo.value = false
        // store.state.siabsen.showPresenceDialog = false
      }

      takePicture.value = () => {   
        const notifyProgress = $q.notify({
          group: false,
          message: t('siabsen_validasi_lokasi'),
          color: 'info',
          position: 'center',
          timeout: 0,
          spinner: true
        })

        const validatePosition = pos => {         
          // implicitly close progress notification
          notifyProgress({ timeout: 1 })
          
          const crd = pos.coords
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
                  position: 'top',
                  timeout: 5000,
                  actions: [
                    { 
                      label: 'X' /* t('siabsen_cek_posisi') */, color: 'white', handler: () => {
                        //window.open(`https://www.google.com/maps/@${crd.latitude},${crd.longitude},15z`, '_blank')
                      } 
                    }
                  ]
                })
              } else if(data.code === 200) {
                setTimeout(() => {
                  const context = canvas.value.getContext('2d')
            
                  context.drawImage(video.value, 0, 0, canvas.value.width, canvas.value.height);
                  imgSrc.value = canvas.value.toDataURL('image/jpeg')
                  let base64String = imgSrc.value.split(',')
                  store.state.siabsen.base64String = base64String[1]
                  store.dispatch('siabsen/pushPresence', {
                    lat: location.value.lat,
                    long: location.value.long
                  })
                }, 500);
              }
            })          
        }

        navigator.geolocation.getCurrentPosition(validatePosition, getLocationError, locationOptions)        
      }

      const presenceSuccess = computed(() => store.state.siabsen.presenceSuccess)
      watch(presenceSuccess, () => {
        if(store.state.siabsen.presenceSuccess) {
          stopVideo.value()
          store.state.siabsen.showPresenceDialog = false
          if($q.screen.lt.sm) {
            router.push('/teacher/home')
          }
        }
      })
    })
    

    return {
      maximizedDialog,
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