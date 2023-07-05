<template>
  <div>
    <q-scroll-area class="table-scroll-area mobile-hide">
      <permit-list />
    </q-scroll-area>
    <permit-list class="mobile-only" />
    <q-separator />
    <ss-paging v-model="store.current" />
  </div>
</template>
<script>
import PermitList from './PermitList.vue'
import { useSiabsenStore } from 'src/stores/siabsen'

export default {
  components: {
    PermitList,
  },
  setup() {
    const store = useSiabsenStore()

    return { store }
  },
}
</script>
