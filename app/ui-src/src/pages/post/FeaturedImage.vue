<template>
  <q-img
    v-if="featuredImageUrl !== null"
    :src="featuredImageUrl"
    style="width: 100%; height: 200px"
    fit="cover"
    class="q-my-md rounded-borders shadow-3"
  >
    <div class="absolute-top-right" style="padding: 0 !important">
      <q-btn
        icon="delete"
        :label="$t('hapus')"
        class="delete-btn"
        style="border-radius: 0 0 0 4px !important"
        @click="$emit('action')"
      />
    </div>
  </q-img>
</template>

<script setup>
const props = defineProps(['featuredImageUrl'])
const emit = defineEmits(['action'])
</script>
