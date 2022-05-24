<template>
  <div class="q-pa-md">    
    <presence-center />
    <updates />
    <welcome />
  </div>
</template>

<script>
import Updates from 'pages/home/Updates.vue'
import Welcome from 'pages/home/Welcome.vue'
import PresenceCenter from 'src/pages/siabsen/dashboard/PresenceCenter.vue'
export default {
  name: 'TeacherIndex',
  components: {
    Welcome,
    Updates,
    PresenceCenter
},
  beforeRouteEnter(to, from) {
    if(from.fullPath === '/login') {
      window.location.reload()
    }
  }
}
</script>
