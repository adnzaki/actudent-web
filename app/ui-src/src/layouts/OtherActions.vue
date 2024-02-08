<template>
  <q-item
    clickable
    v-ripple
    :class="['q-pr-xl', accountMenu]"
    :to="link"
    v-close-popup
  >
    <q-item-section avatar>
      <q-icon :name="icon" />
    </q-item-section>
    <q-item-section>
      {{ label }}
    </q-item-section>
  </q-item>
</template>
<script>
import { computed } from 'vue'
import { headerColor } from 'src/composables/mode'

export default {
  props: ['link', 'icon', 'label'],
  setup() {
    const accountMenu = computed(() => {
      return headerColor.value === 'dark' ? 'account-menu-item-dark' : ''
    })

    return { accountMenu }
  },
}
</script>
