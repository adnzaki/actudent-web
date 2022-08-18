<template>
  <div class="q-pa-md">  
    <presence-flash-recap />   
    <updates />
  </div>
</template>

<script>
import PresenceFlashRecap from 'src/siabsen_pages/dashboard/PresenceFlashRecap.vue'
import Updates from './Updates.vue'
export default {
  name: 'PageIndex',
  components: {
    PresenceFlashRecap,
    Updates
  },
  beforeRouteEnter(to, from) {
    if(from.fullPath === '/login') {
      window.location.reload()
    }
  }
}
</script>
