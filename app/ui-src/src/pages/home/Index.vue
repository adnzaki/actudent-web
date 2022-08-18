<template>
  <div class="q-pa-md">    
    <updates />
  </div>
</template>

<script>
import Updates from './Updates.vue'
export default {
  name: 'PageIndex',
  components: {
    Updates
  },
  beforeRouteEnter(to, from) {
    if(from.fullPath === '/login') {
      window.location.reload()
    }
  }
}
</script>
