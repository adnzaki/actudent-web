<template>
  <div class="row">
    <div class="col-12">
      <p class="text-center">
        {{ text }} <q-spinner-orbit :color="color" :size="size" />
      </p>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  text: String,
  size: {
    type: String,
    default: '2em',
  },
  color: {
    type: String,
    default: 'primary',
  },
})
</script>
