<template>
  <div class="col-12 col-sm-6">
    <div class="q-gutter-xs">
      <q-btn
        color="deep-purple"
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

<script>
import { fabPos } from 'src/composables/fab'
import { useSiabsenStore } from 'src/stores/siabsen'

export default {
  setup() {
    const store = useSiabsenStore()
    return {
      showForm: () => (store.showPermitForm = true),
      fabPos,
    }
  },
}
</script>
