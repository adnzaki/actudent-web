<template>
  <q-item 
    clickable v-ripple class="q-pr-xl"
    :to="link"
    v-close-popup>
    <q-item-section avatar>
      <q-icon :name="icon" />
    </q-item-section>
    <q-item-section>
      {{ label }}
    </q-item-section>
  </q-item>
</template>
<script>
export default {
  props: ['link', 'icon', 'label'],
  setup() {
    
  }
}
</script>