<template>
  <div style="width: 100%">
    <p class="text-h5 text-bold">{{ store.forms.timeline_title }}</p>
    <q-img
      :style="{ width: '100%', height: featuredImageHeight }"
      fit="cover"
      class="q-my-md rounded-borders shadow-3"
      v-if="getImage(store.forms.featured_image) !== null"
      :src="getImage(store.forms.featured_image)"
    ></q-img>
    <p class="text-grey-8">
      <q-icon name="o_mode_edit" style="margin-top: -3px" />
      {{ store.postInfo.author }} |
      <q-icon name="o_schedule" style="margin-top: -3px" />
      {{ store.postInfo.date }}
    </p>

    <p v-html="store.postInfo.content"></p>

    <!-- Carousel Gallery -->
    <p class="text-h6 text-bold" v-if="store.galleryList.length > 0">
      {{ $t('timeline_gallery') }}
    </p>
    <q-carousel
      animated
      v-model="activeImage"
      v-model:fullscreen="fullscreen"
      arrows
      swipeable
      infinite
      control-color="primary"
      transition-prev="slide-right"
      transition-next="slide-left"
      class="rounded-borders shadow-3 q-mb-md"
      :thumbnails="$q.screen.gt.sm"
      :height="galleryHeight"
      v-if="store.galleryList.length > 0"
    >
      <q-carousel-slide
        v-for="(item, index) in store.galleryList"
        :name="item.id"
        :key="index"
        :img-src="getImage(item.filename)"
      />
      <template v-slot:control>
        <q-carousel-control position="bottom-right" :offset="[18, 18]">
          <q-btn
            round
            dense
            color="primary"
            text-color="white"
            :icon="fullscreen ? 'fullscreen_exit' : 'fullscreen'"
            @click="fullscreen = !fullscreen"
          />
        </q-carousel-control>
      </template>
    </q-carousel>
    <q-btn
      icon="file_download"
      unelevated
      :style="inviteBtn"
      :class="addButton"
      :label="$t('timeline_download_media')"
      @click="downloadMedia"
    />
  </div>
</template>

<script setup>
import { useQuasar } from 'quasar'
import { ref, reactive, computed, watch } from 'vue'
import { usePostStore } from 'src/stores/post'
import { conf, bearerToken, addButton, admin } from 'src/composables/common'

const store = usePostStore()
const $q = useQuasar()
const activeImage =
  $q.screen.lt.sm || store.galleryList[0] === undefined
    ? ref(null)
    : ref(store.galleryList[0].id)

const downloadMedia = () => {
  admin
    .get(`${store.postApi}download-media/${store.postId}`, {
      headers: { Authorization: bearerToken },
    })
    .then(({ data }) => {
      window.open(data.url, '_blank')
    })
}

const inviteBtn = reactive({
  width: $q.screen.lt.sm ? '98%' : '99%',
  marginLeft: 0,
  marginTop: '15px',
})
const gallery = computed(() => store.galleryList)

watch(gallery, () => {
  if (gallery.value.length > 0) {
    activeImage.value = gallery.value[0].id
  }
})

const fullscreen = ref(false)
const featuredImageHeight = computed(() =>
  $q.screen.lt.sm ? '200px' : '350px'
)

const galleryHeight = computed(() => ($q.screen.lt.sm ? '200px' : '320px'))

const getImage = (filename) => {
  if (filename !== '' && filename !== null && filename !== 'null') {
    const imagePath = `${conf.baseUrl()}images/posts/`
    const folder = filename.split('_')[0] + '/'

    return `${imagePath}${folder}${filename}`
  } else {
    return null
  }
}

const imgSrc = computed(() => `${conf.adminAPI}post/content/${store.postId}`)
</script>
