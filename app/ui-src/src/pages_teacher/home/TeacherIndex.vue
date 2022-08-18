<template>
  <div class="q-pa-md">    
    <updates />
  </div>
</template>

<script>
import Updates from 'pages/home/Updates.vue'
export default {
  name: 'TeacherIndex',
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
