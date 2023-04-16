<template>
  <small class="text-negative" style="margin-bottom: 30px">
    {{ label }}
  </small>
</template>

<script>
export default {
  name: 'ErrorMessage',
  props: ['label'],
}
</script>
