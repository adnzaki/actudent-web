<template>
  <div class="col-12 col-sm-6">
    <div class="q-gutter-xs">
      <q-btn
        :class="addButton"
        icon="add"
        class="q-pl-sm mobile-hide"
        :label="$t('tambah')"
        @click="showForm"
      />
    </div>
  </div>
  <q-page-sticky
    position="bottom-right"
    :offset="fabPos"
    class="mobile-only force-elevated"
  >
    <q-btn fab icon="add" color="deep-purple" @click="showForm" />
  </q-page-sticky>
</template>

<script setup>
import { fabPos } from 'src/composables/fab'
import { useSiabsenStore } from 'src/stores/siabsen'
import { addButton } from 'src/composables/mode'

const store = useSiabsenStore()
const showForm = () => (store.showPermitForm = true)
</script>
