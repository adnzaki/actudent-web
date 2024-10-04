<template>
    <div>
      <q-scroll-area class="table-scroll-area mobile-hide">
        <leave-list />
      </q-scroll-area>
      <leave-list class="mobile-only" />
      <q-separator />
      <ss-paging v-model="store.current" />
    </div>
  </template>
  <script>
  import LeaveList from './LeaveList.vue'
  import { useSiabsenStore } from 'src/stores/siabsen'
  
  export default {
    components: {
        LeaveList,
    },
    setup() {
      const store = useSiabsenStore()
  
      return { store }
    },
  }
  </script>
  