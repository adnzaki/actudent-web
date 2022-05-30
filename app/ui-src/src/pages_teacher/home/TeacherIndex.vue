<template>
  <div class="q-pa-md">    
    <presence-center />
    <presence-dialog />
    <updates />
    <welcome />
  </div>
</template>

<script>
import Updates from 'pages/home/Updates.vue'
import Welcome from 'pages/home/Welcome.vue'
import PresenceCenter from 'src/siabsen_pages/dashboard/PresenceCenter.vue'
import PresenceDialog from 'src/siabsen_pages/dashboard/PresenceDialog.vue'
export default {
  name: 'TeacherIndex',
  components: {
    Welcome,
    Updates,
    PresenceCenter,
    PresenceDialog
},
  beforeRouteEnter(to, from) {
    if(from.fullPath === '/login') {
      window.location.reload()
    }
  }
}
</script>
