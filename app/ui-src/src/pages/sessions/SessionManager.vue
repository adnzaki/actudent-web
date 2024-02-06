<template>
  <div :class="wrapperPadding()">
    <HistoryMain />
  </div>
</template>
<script setup>
import { wrapperPadding } from 'src/composables/screen'
import HistoryMain from './HistoryMain.vue'
</script>
