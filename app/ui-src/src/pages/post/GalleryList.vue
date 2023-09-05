<template>
  <q-item clickable v-ripple>
    <q-item-section>
      <q-img style="max-width: 150px; max-height: 70px" :src="src" />
    </q-item-section>
    <q-item-section side>
      <q-btn
        icon="delete"
        :label="$t('hapus')"
        class="delete-btn"
        @click="$emit('action')"
      />
    </q-item-section>
  </q-item>
</template>
<script setup>
const props = defineProps({
  src: { type: String },
})

const emit = defineEmits(['action'])
</script>
