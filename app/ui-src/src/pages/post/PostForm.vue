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
            :max-file-size="2048 * 1000"
            accept=".jpg, image/*"
            max-files="1"
            auto-upload
            :headers="[{ name: 'Authorization', value: bearerToken }]"
            field-name="featured_image"
            @uploaded="onUploaded"
            @rejected="onReject"
            @start="uploadStart"
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

          <h6 class="q-mt-md">{{ $t('timeline_gallery') }}</h6>
          <q-uploader
            style="width: 100%; margin-top: -25px"
            :url="`${conf.adminAPI}post/upload-image-gallery`"
            :label="$t('timeline_gallery_desc')"
            :max-file-size="2048 * 1000"
            accept=".jpg, image/*"
            max-files="10"
            multiple
            auto-upload
            :headers="[{ name: 'Authorization', value: bearerToken }]"
            field-name="image_gallery"
            @uploaded="onGalleryUpload"
            @rejected="onGalleryReject"
            @start="uploadStart"
          />
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
        />
        <q-btn
          :label="$t('simpan')"
          class="mobile-form-btn save-btn"
          unelevated
          :disable="disableSaveButton"
          @click="save"
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

const store = usePostStore()
const publish = ref(true)

const formOpen = () => {
  if (store.forms.timeline_content === '') {
    store.forms.timeline_content = t('timeline_placeholder')
  }

  publish.value = store.forms.timeline_status === 'public' ? true : false

  const saveStatus = computed(() => store.saveStatus)
  if (saveStatus.value === 200) {
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

const onStatusChange = (model, evt) => {
  store.forms.timeline_status = model ? 'public' : 'draft'
}

const onUploaded = (info) => {
  const response = JSON.parse(info.xhr.response)
  store.forms.featured_image = response.filename
}

const onGalleryUpload = (info) => {
  const response = JSON.parse(info.xhr.response)
  store.forms.gallery.push(response.filename)
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

const save = () => {
  store.forms.gallery = JSON.stringify(store.forms.gallery)
  store.save({
    edit: false,
    id: null,
  })
}
</script>
