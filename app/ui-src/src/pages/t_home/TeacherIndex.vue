<template>
  <div class="q-pa-md">    
    <updates />
    <welcome />
  </div>
</template>

<script>
import Updates from '../home/Updates.vue'
import Welcome from '../home/Welcome.vue'
export default {
  name: 'TeacherIndex',
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
