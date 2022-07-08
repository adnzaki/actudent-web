<template>
  <q-card class="my-card q-pb-sm">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">
        {{ $t('app_setting_lang') }}
      </div>
      <div class="text-h6 text-capitalize" v-else>
        {{ $t('app_setting_lang') }}
      </div>
      <div :class="['row', titleSpacing()]">
        <p>{{ $t('app_lang_desc') }}</p>
      </div>
      <div style="margin-left: -10px">
        <q-radio v-model="lang" val="indonesia" label="Indonesia" color="teal" />
      </div>
      <div style="margin-left: -10px">
        <q-radio v-model="lang" val="english" label="English" color="teal" />
      </div>
    </q-card-section>
    <q-card-actions align="left" class="q-ml-sm">
      <q-btn :label="$t('simpan')" :disable="disableSaveButton" @click="save" color="primary" padding="8px 20px" />
    </q-card-actions>
  </q-card>
</template>

<script>
import { ref } from 'vue'
import { titleSpacing } from 'src/composables/screen'
import { axios, bearerToken, conf, createFormData } from 'src/composables/common'
import { useQuasar } from 'quasar'

export default {
  setup() {
    const $q = useQuasar()
    const lang = ref('indonesia')
    const disableSaveButton = ref(false)

    if(localStorage.getItem(conf.userLang) !== null) {
      lang.value = localStorage.getItem(conf.userLang)
    }

    const save = () => {
      disableSaveButton.value = true
      axios.post(`${conf.adminAPI}pengaturan/set-bahasa`, { lang: lang.value }, {
          headers: { Authorization: bearerToken },
          transformRequest: [data => createFormData(data)]
        }).then(({ data }) => {
          localStorage.setItem(conf.userLang, lang.value)
          window.location.reload()
        })        
    }

    return {
      disableSaveButton, save,
      lang, titleSpacing
    }
  }
}
</script>