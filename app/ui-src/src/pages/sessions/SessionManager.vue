<template>
  <div :class="wrapperPadding()">
    <SessionMain />
    <HistoryMain />
  </div>
</template>
<script setup>
import { wrapperPadding } from 'src/composables/screen'
import HistoryMain from './HistoryMain.vue'
import SessionMain from './SessionMain.vue'
</script>
