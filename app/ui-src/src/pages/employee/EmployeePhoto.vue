<template>
  <q-img v-if="filename !== '' && filename !== null"
    :src="imageBase64 + filename"
    class="img-thumbnail flex inline shadow-box flex-center shadow-8 q-mb-md"
    spinner-color="white"
    style="height: 160px; max-width: 120px"
  />
</template>
<script>
import { mapState } from 'vuex'

export default {
  name: 'EmployeePhoto',
  computed: {
    ...mapState('employee', {
      filename: state => state.helper.filename,
      imageBase64: state => state.helper.imageBase64
    }),
  }
}
</script>