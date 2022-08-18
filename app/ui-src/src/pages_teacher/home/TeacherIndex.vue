<template>
  <div class="q-pa-md">    
    <presence-center />
    <presence-dialog />
    <updates />
  </div>
</template>

<script>
import PresenceCenter from 'src/siabsen_pages/dashboard/PresenceCenter.vue'
import PresenceDialog from 'src/siabsen_pages/dashboard/PresenceDialog.vue'
import Updates from 'pages/home/Updates.vue'
export default {
  name: 'TeacherIndex',
  components: {
    PresenceCenter,
    PresenceDialog,
    Updates
  },
  beforeRouteEnter(to, from) {
    if(from.fullPath === '/login') {
      window.location.reload()
    }
  }
}
</script>
