<template>
  <q-card class="my-card">
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
        <q-radio v-model="lang" @update:model-value="save" val="indonesia" label="Indonesia" color="teal" />
      </div>
      <div style="margin-left: -10px" class="q-mb-sm">
        <q-radio v-model="lang" @update:model-value="save" val="english" label="English" color="teal" />
      </div>
      <p v-if="progress"><i>{{ $t('mohon_tunggu') }}</i></p>
    </q-card-section>
  </q-card>
</template>

<script>
import { ref } from 'vue'
import { titleSpacing } from 'src/composables/screen'
import { axios, bearerToken, conf, createFormData } from 'src/composables/common'

export default {
  setup() {
    const lang = ref('indonesia')
    const progress = ref(false)

    if(localStorage.getItem(conf.userLang) !== null) {
      lang.value = localStorage.getItem(conf.userLang)
    }

    const save = val => {
      progress.value = true
      setTimeout(() => {
        axios.post(`${conf.adminAPI}pengaturan/set-bahasa`, { lang: val }, {
          headers: { Authorization: bearerToken },
          transformRequest: [data => createFormData(data)]
        }).then(({ data }) => {
          localStorage.setItem(conf.userLang, lang.value)
          window.location.reload()
        })                
      }, 1500)
    }

    return {
      progress,
      save, lang, titleSpacing
    }
  }
}
</script>