<template>
  <div class="q-pa-md">   
    <presence-flash-recap /> 
    <updates />
    <!-- <welcome /> -->
  </div>
</template>

<script>
import Updates from './Updates.vue'
import Welcome from './Welcome.vue'
import PresenceFlashRecap from 'src/siabsen_pages/dashboard/PresenceFlashRecap.vue'
export default {
  name: 'PageIndex',
  components: {
    Welcome,
    Updates,
    PresenceFlashRecap
},
  beforeRouteEnter(to, from) {
    if(from.fullPath === '/login') {
      window.location.reload()
    }
  }
}
</script>
