<template>
  <q-card class="my-card q-pb-sm q-mt-md">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">
        {{ $t('app_setting_theme') }}
      </div>
      <div class="text-h6 text-capitalize" v-else>
        {{ $t('app_setting_theme') }}
      </div>
      <div :class="['row', titleSpacing()]">
        <p>{{ $t('app_theme_desc') }}</p>
      </div>      
      <div style="margin-left: -10px">
        <q-radio v-model="theme" 
          @update:model-value="changeTheme" 
          val="light" 
          :label="$t('app_theme_light')" 
          color="teal" />
      </div>
      <div style="margin-left: -10px">
        <q-radio v-model="theme" 
          @update:model-value="changeTheme" 
          val="dark" 
          :label="$t('app_theme_dark')" 
          color="teal" />
      </div>
    </q-card-section>
  </q-card>
</template>

<script>
import { ref } from 'vue'
import { titleSpacing } from 'src/composables/screen'
import { useQuasar } from 'quasar'
import { toggleHeader } from 'src/composables/mode'

export default {
  setup() {
    const $q = useQuasar()
    const theme = ref('light')

    if($q.cookies.get('theme') !== null) {
      theme.value = $q.cookies.get('theme')
    }

    const changeTheme = val => {
      if(val === 'dark') {
        $q.dark.set(true)
      } else {
        $q.dark.set(false)
      }

      $q.cookies.set('theme', val, { expires: 365, secure: true })
      toggleHeader()
    }

    return {
      theme,
      changeTheme,
      titleSpacing
    }
  }
}
</script>