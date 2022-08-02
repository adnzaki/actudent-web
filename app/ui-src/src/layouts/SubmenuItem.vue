<template>
  <q-item 
    :active-class="activeClass"
    clickable v-ripple 
    :inset-level="1" 
    :to="link">
    <q-item-section>
      {{ label }}
    </q-item-section>
  </q-item>
</template>
<script>
import { inject } from 'vue'

export default {
  props: ['link', 'label'],
  setup() {
    const activeClass = inject('activeClass')

    return {
      activeClass
    }
  },
}
</script>