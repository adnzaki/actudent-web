<template>
  <q-tooltip anchor="top middle" self="bottom middle" :offset="[10, 10]">
    {{ label }}
  </q-tooltip>
</template>

<script>

export default {
  name: 'BtnTooltip',
  props: ['label']
}
</script>
