<template>
  <div class="elevated">
    <q-btn round color="primary" icon="brightness_4" @click="toggleMode">
      <q-tooltip class="bg-accent">{{ lang.pindah_mode }}</q-tooltip>
    </q-btn>
  </div>
</template>

<style lang="scss" scoped>
.elevated {
  position: fixed;
  right: 30px;
  bottom: 30px;
  z-index: 9999;
}
</style>

<script>
import { useQuasar } from 'quasar'
import { defineComponent } from 'vue'
import { toggleHeader } from '../composables/mode-comp'
import locale from '../mixins/fetch-lang'

export default defineComponent({
  name: 'ToggleMode',
  mixins: [locale],
  mounted() {
    setTimeout(() => {
      this.fetchLang('Admin')
    }, 500);
  },
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
})
</script>
