<template>
  <q-img v-if="filename !== '' && filename !== null"
    :src="imageBase64 + filename"
    class="img-thumbnail flex inline shadow-box flex-center shadow-8 q-mb-md"
    spinner-color="white"
    style="height: 160px; max-width: 120px"
  />
</template>
<script>
import { useEmployeeStore } from 'src/stores/employee'

export default {
  setup() {
    const store = useEmployeeStore()

    return {
      filename: store.helper.filename,
      imageBase64: store.helper.imageBase64  
    }
  }
}
</script>