<template>
  <div>
    <q-scroll-area class="table-scroll-area mobile-hide">
      <permit-list />
    </q-scroll-area>
    <permit-list class="mobile-only" />
    <q-separator/>
    <ss-paging vuex-module="siabsen" />
  </div>
</template>
<script>
import PermitList from './PermitList.vue'
export default {
  components: {
    PermitList
  },
  setup() {
    
  }
}
</script>