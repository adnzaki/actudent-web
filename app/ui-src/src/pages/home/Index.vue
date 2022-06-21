<template>
  <div class="q-pa-md">    
    <updates />
    <!-- <welcome /> -->
  </div>
</template>

<script>
import Updates from './Updates.vue'
import Welcome from './Welcome.vue'
export default {
  name: 'PageIndex',
  components: {
    Welcome,
    Updates
  },
  beforeRouteEnter(to, from) {
    if(from.fullPath === '/login') {
      window.location.reload()
    }
  }
}
</script>
