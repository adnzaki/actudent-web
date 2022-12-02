<template>
  <q-tooltip :anchor="anchor" :self="self" :offset="[10, 10]">
    {{ label }}
  </q-tooltip>
</template>

<script>

export default {
  name: 'BtnTooltip',
  props: {
    label: {
      type: String
    },
    anchor: {
      type: String,
      default: 'top middle'
    },
    self: {
      type: String,
      default: 'bottom middle'
    }
  }
}
</script>
