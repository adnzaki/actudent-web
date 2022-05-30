<template>
  <div class="q-pa-md">
    <div class="row">
      <div class="col-12">
        <video ref="video" autoplay v-if="showVideo" style="width: 100%">Video tidak tersedia</video>
        <canvas ref="canvas" width="320" height="240" style="display: none"></canvas>
        <img :src="imgSrc" />
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <p>Informasi lokasi: 
          <a :href="mapsURL" target="_blank" rel="noopener noreferrer">{{ locationDescription }}</a>
        </p>
        <p>Keterangan: {{ validationStatus }}</p>
        <div class="row q-gutter-sm">
          <q-btn color="secondary" @click="openCamera" rounded>Buka kamera</q-btn>
          <q-btn color="primary" @click="takePicture" rounded v-if="canTakePicture">Ambil gambar</q-btn>
        </div>
      </div>
    </div>
    
  </div>
</template>
<script>
import { onMounted, ref } from 'vue'
import { axios, conf, createFormData, bearerToken } from 'src/composables/common'

export default {
  setup() {
    const video = ref(null)
    const canvas = ref(null)
    const openCamera = ref(null)
    const takePicture = ref(null)
    const showVideo = ref(false)
    const imgSrc = ref('')
    const locationDescription = ref('')
    const mapsURL = ref('')
    const canTakePicture = ref(false)
    const validationStatus = ref('')

    const locationOptions = {
      enableHighAccuracy: true,
      timeout: 5000,
      maximumAge: 0
    }

    const getLocationSuccess = pos => {
      const crd = pos.coords
      locationDescription.value = `${crd.latitude}, ${crd.longitude} (Akurasi: ${crd.accuracy} meter)`
      mapsURL.value = `https://www.google.com/maps/@${crd.latitude},${crd.longitude},15z`
      const crdData = {
        latTo: crd.latitude,
        longTo: crd.longitude
      }

      axios.post(`${conf.siabsenAPI}validate-position`, crdData, {
        headers: { Authorization: bearerToken },
        transformRequest: [data => {
          return createFormData(data)
        }]
      })
        .then(({ data }) => {
          if(data.code === 500) {
            canTakePicture.value = false            
          } else if(data.code === 200) {
            canTakePicture.value = true
          }

          validationStatus.value = data.msg
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

      const context = canvas.value.getContext('2d')

      takePicture.value = () => {
        context.drawImage(video.value, 0, 0, canvas.value.width, canvas.value.height);
        imgSrc.value = canvas.value.toDataURL('image/jpeg')

        video.value.srcObject.getVideoTracks().forEach(track => track.stop())
        showVideo.value = false
      }
    })

    return {
      canTakePicture,
      validationStatus,
      mapsURL,
      locationDescription,
      imgSrc,
      showVideo,
      takePicture,
      openCamera,
      video,
      canvas
    }
  }
}
</script>