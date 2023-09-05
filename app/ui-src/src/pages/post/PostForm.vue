<template>
  <q-dialog
    no-backdrop-dismiss
    v-model="store.showForm"
    @before-show="formOpen"
    :maximized="maximizedDialog()"
  >
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">
          {{ $t('timeline_add_post_title') }}
        </div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">
          <q-input
            outlined
            :label="$t('timeline_label_post')"
            dense
            v-model="store.forms.timeline_title"
          />
          <ac-error :label="error.timeline_title" />

          <q-editor
            class="q-mt-sm"
            :toolbar="[
              ['left', 'center', 'right', 'justify'],
              ['bold', 'italic', 'strike', 'underline'],
              ['undo', 'redo'],
              [
                {
                  label: $q.lang.editor.formatting,
                  icon: $q.iconSet.editor.formatting,
                  list: 'no-icons',
                  options: ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'code'],
                },
              ],
              ['quote', 'unordered', 'ordered', 'outdent', 'indent'],
            ]"
            v-model="store.forms.timeline_content"
            min-height="10rem"
          />
          <!-- <ac-error :label="error.timeline_content" /> -->

          <q-toggle
            v-model="publish"
            @update:model-value="onStatusChange"
            :label="$t('timeline_publish')"
            class="q-my-sm"
          />

          <q-uploader
            style="width: 100%"
            :url="`${conf.adminAPI}post/upload-featured-image`"
            :label="$t('timeline_label_image')"
            :max-file-size="10000 * 1000"
            accept=".jpg, image/*"
            max-files="1"
            auto-upload
            :headers="[{ name: 'Authorization', value: bearerToken }]"
            field-name="featured_image"
            @uploaded="onUploaded"
            @rejected="onReject"
            @start="featuredUploadStart"
            ref="featuredImageUploader"
          />
          <div v-if="errorUpload.length > 0">
            <p class="q-mt-md text-orange-8 text-bold">
              {{ $t('timeline_upload_failed') }}
            </p>
            <ul>
              <li v-for="(item, index) in errorUpload" :key="index">
                <b>{{ item.file }}: {{ item.reason }}</b>
              </li>
            </ul>
          </div>

          <featured-image
            v-if="!store.isEditForm"
            :featured-image-url="featuredImageUrl"
            @action="store.removeFeaturedImage()"
          />
          <featured-image
            v-if="store.isEditForm"
            :featured-image-url="featuredImageUrl"
            @action="
              store.deleteImage('delete-featured-image', store.postId, 'post')
            "
          />

          <h6 class="q-mt-md">{{ $t('timeline_gallery') }}</h6>
          <q-uploader
            style="width: 100%; margin-top: -25px"
            :url="`${conf.adminAPI}post/upload-image-gallery`"
            :label="$t('timeline_gallery_desc')"
            :max-file-size="10000 * 1000"
            accept=".jpg, image/*"
            :max-files="galleryLimit"
            multiple
            auto-upload
            :headers="[{ name: 'Authorization', value: bearerToken }]"
            field-name="image_gallery"
            @uploaded="onGalleryUploaded"
            @rejected="onGalleryReject"
            @start="galleryUploadStart"
            @added="onFileSelected"
            ref="galleryUploader"
            :disable="store.disableGalleryUploader"
          />
          <!-- <q-banner
            inline-actions
            class="text-white bg-red rounded-borders q-mt-md"
            
          >
            You have lost connection to the internet. This app is offline.
            <template v-slot:action>
              <q-btn flat color="white" label="Turn ON Wifi" />
            </template>
          </q-banner> -->
          <div v-if="errorGalleryUpload.length > 0">
            <p class="q-mt-md text-orange-8 text-bold">
              {{ $t('timeline_upload_failed') }}
            </p>
            <ul>
              <li v-for="(item, index) in errorGalleryUpload" :key="index">
                <b>{{ item.file }}: {{ item.reason }}</b>
              </li>
            </ul>
          </div>

          <q-list
            v-if="store.forms.gallery.length > 0"
            bordered
            separator
            class="q-my-md"
          >
            <gallery-list
              v-for="(item, index) in store.forms.gallery"
              :key="index"
              :src="getImage(item)"
              @action="removeGalleryImage(item, index)"
            ></gallery-list>
          </q-list>

          <q-list
            v-if="store.galleryList.length > 0 && store.isEditForm"
            bordered
            separator
            class="q-my-md"
          >
            <gallery-list
              v-for="(item, index) in store.galleryList"
              :key="index"
              :src="getImage(item.filename)"
              @action="
                store.deleteImage('delete-image-gallery', item.id, 'gallery')
              "
            ></gallery-list>
          </q-list>
        </q-form>
      </q-card-section>

      <q-separator />
      <q-card-actions align="right">
        <q-btn
          flat
          :label="$t('tutup')"
          v-if="!$q.screen.lt.sm"
          color="negative"
          v-close-popup
          class="close-btn"
          @click="formClose"
        />
        <q-btn
          :label="$t('simpan')"
          class="mobile-form-btn save-btn"
          unelevated
          :disable="store.helper.disableSaveButton"
          @click="store.save()"
        />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script setup>
import { ref, computed } from 'vue'
import { usePostStore } from 'src/stores/post'
import { conf, bearerToken, t } from 'src/composables/common'
import { maximizedDialog, cardDialog } from '../../composables/screen'
import FeaturedImage from './FeaturedImage.vue'
import GalleryList from './GalleryList.vue'

const store = usePostStore()
const publish = ref(true)
const featuredImageUploader = ref(null)
const galleryUploader = ref(null)

const formOpen = () => {
  if (store.forms.timeline_content === '') {
    store.forms.timeline_content = t('timeline_placeholder')
  }

  // check existing image gallery
  // it it reaches the limit, disable the uploader
  if (galleryCount.value < galleryLimit.value) {
    store.disableGalleryUploader = false
  } else {
    store.disableGalleryUploader = true
  }

  publish.value = store.forms.timeline_status === 'public' ? true : false

  const saveStatus = computed(() => store.saveStatus)
  if (saveStatus.value === 200 || !store.isEditForm) {
    store.forms = {
      timeline_title: '',
      timeline_content: t('timeline_placeholder'),
      timeline_status: 'public',
      featured_image: '',
      gallery: [],
    }

    store.saveStatus = 500
  }
}

const formClose = () => {
  if (store.isEditForm) store.isEditForm = false
  if (store.forms.gallery.length > 0) {
    store.forms.gallery.forEach((item, index) => {
      removeGalleryImage(item, index)
    })
  }

  if (store.forms.featured_image !== '') {
    store.removeFeaturedImage()
  }
}

const featuredImageUrl = computed(() => {
  const filename = store.forms.featured_image
  if (filename !== '' && filename !== null && filename !== 'null') {
    return getImage(filename)
  } else {
    return null
  }
})

const getImage = (filename) => {
  const imagePath = `${conf.baseUrl()}images/posts/`
  const folder = filename.split('_')[0] + '/'

  return `${imagePath}${folder}${filename}`
}

const error = computed(() => store.error)

const onStatusChange = (model, evt) => {
  store.forms.timeline_status = model ? 'public' : 'draft'
}

const onUploaded = (info) => {
  const response = JSON.parse(info.xhr.response)
  store.forms.featured_image = response.filename
  featuredImageUploader.value.removeUploadedFiles()
}

const removeGalleryImage = (filename, index) => {
  store.removeGalleryImage({
    filename,
    index,
    limit: galleryLimit.value,
  })
}

const onGalleryUploaded = (info) => {
  const response = JSON.parse(info.xhr.response)
  store.forms.gallery.push(response.filename)
  galleryUploader.value.removeUploadedFiles()

  // reset selected files after upload
  selectedFiles.value = 0
  if (galleryCount.value >= galleryLimit.value) {
    store.disableGalleryUploader = true
  }
}

const errorUpload = ref([])
const errorGalleryUpload = ref([])
const reason = {
  'max-file-size': t('file_too_large'),
  accept: t('invalid_filetype'),
}

const onReject = (entries) => {
  // reset first
  errorUpload.value = []

  entries.forEach((item) => {
    errorUpload.value.push({
      file: item.file.name,
      reason: reason[item.failedPropValidation],
    })
  })
}

const onGalleryReject = (entries) => {
  // reset first
  errorGalleryUpload.value = []

  entries.forEach((item) => {
    errorGalleryUpload.value.push({
      file: item.file.name,
      reason: reason[item.failedPropValidation],
    })
  })
}

const featuredUploadStart = () => {
  errorUpload.value = []

  if (store.forms.featured_image !== '') {
    store.removeFeaturedImage()
  }
}

const galleryLimit = ref(10)

const galleryCount = computed(() => {
  return store.galleryList.length + store.forms.gallery.length
})

const galleryUploadStart = () => {
  errorGalleryUpload.value = []
}

const selectedFiles = ref(0)

const onFileSelected = (files) => {
  selectedFiles.value += files.length
  if (selectedFiles.value + store.galleryCount > galleryLimit.value) {
    galleryUploader.value.abort()
    galleryUploader.value.removeQueuedFiles()
    galleryUploader.value.removeUploadedFiles()

    // reset selectedFiles if upload is aborted
    selectedFiles.value = 0
  }
}
</script>
