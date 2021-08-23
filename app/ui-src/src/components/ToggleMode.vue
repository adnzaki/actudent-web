<template>
  <q-btn flat round dense icon="brightness_4" @click="toggleMode">
    <q-tooltip class="bg-accent">{{ $t('pindah_mode') }}</q-tooltip>
  </q-btn>
</template>

<style lang="scss" scoped>
.elevated {
  position: fixed;
  right: 25px;
  top: 75px;
  z-index: 9999;
}
</style>

<script>
import { useQuasar } from 'quasar'
import { toggleHeader } from '../composables/mode'

export default {
  name: 'ToggleMode',
  setup () {
    const $q = useQuasar()
    let currentMode = 'light'
    const toggleMode = () => {
      $q.dark.toggle()
      $q.dark.isActive ? currentMode = 'dark' : currentMode = 'light'
      $q.cookies.set('theme', currentMode, { expires: 10, secure: true })
      toggleHeader()
    }

    return {
      toggleMode
    }
  }
}
</script>
