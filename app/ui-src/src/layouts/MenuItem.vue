<template>
  <q-item
    :active-class="activeClass"
    clickable v-ripple 
    :to="link">
    <q-item-section avatar>
      <q-icon :name="icon" />
    </q-item-section>
    <q-item-section>
      {{ label }}
    </q-item-section>
  </q-item>
</template>
<script>
import { inject } from 'vue'

export default {
  props: ['link', 'icon', 'label'],
  setup() {
    const activeClass = inject('activeClass')

    return {
      activeClass
    }
  },
}
</script>