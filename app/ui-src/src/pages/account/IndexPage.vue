<template>
  <div :class="wrapperPadding()">
    <ChangePassword />
    <div v-if="userLevel === '1'">
      <CopyToken />
    </div>
  </div>
</template>

<script>
import { wrapperPadding } from 'src/composables/screen'
import ChangePassword from './ChangePassword.vue'
import CopyToken from './CopyToken.vue'
import { Cookies, conf } from 'src/composables/common'

export default {
  components: { ChangePassword, CopyToken },
  setup() {
    return {
      userLevel: Cookies.get(conf.userType),
      wrapperPadding,
    }
  },
}
</script>
