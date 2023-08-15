<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">
        {{ $t('letterhead_image') }}
      </div>
      <div class="text-h6 text-capitalize" v-else>
        {{ $t('letterhead_image') }}
      </div>
      <div :class="['row', titleSpacing()]">
        <p>{{ $t('letterhead_desc') }}</p>
      </div>

      <q-uploader
        style="width: 100%"
        :url="`${conf.adminAPI}pengaturan-laporan/upload-kop`"
        :label="$t('letterhead_explain')"
        :max-file-size="2048 * 1000"
        accept=".jpg, image/*"
        max-files="1"
        :headers="[{ name: 'Authorization', value: bearerToken }]"
        field-name="letterhead_image"
        ref="uploader"
        @uploaded="onUploaded"
      />
    </q-card-section>
  </q-card>
</template>

<script>
import { ref } from 'vue'
import { titleSpacing } from 'src/composables/screen'
import {
  axios,
  conf,
  createFormData,
  bearerToken,
  t,
} from 'src/composables/common'

import { useQuasar } from 'quasar'

export default {
  setup() {
    const progress = ref(false)
    const uploader = ref(null)
    const $q = useQuasar()
    const onUploaded = () => {
      $q.notify({
        message: t('letterhead_success'),
        color: 'positive',
        icon: 'done',
        timeout: 3500,
        position: 'center',
      })
      // uploader.value.removeUploadedFiles()
    }

    const save = (val) => {
      progress.value = true
      // setTimeout(() => {
      //   axios.post(`${conf.adminAPI}pengaturan/set-bahasa`, { lang: val }, {
      //     headers: { Authorization: bearerToken },
      //     transformRequest: [data => createFormData(data)]
      //   }).then(({ data }) => {
      //     localStorage.setItem(conf.userLang, lang.value)
      //     window.location.reload()
      //   })
      // }, 1500)
    }

    return {
      conf,
      save,
      progress,
      uploader,
      onUploaded,
      bearerToken,
      titleSpacing,
    }
  },
}
</script>
