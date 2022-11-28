<template>
  <div :class="wrapperPadding()">    
    <q-card class="my-card">
      <q-card-section>
        <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ $t('user_title') }}</div>
        <div class="text-h6 text-capitalize" v-else>{{ $t('user_title') }}</div>
        <div :class="['row', titleSpacing()]">
          <!-- <main-button class="q-mt-sm" /> -->
          <user-type class="justify-data-options" />
          <row-dropdown vuex-module="users" class="q-mt-sm" root-class="col-12 col-md-2" />
          <search-box :label="$t('user_cari')" vuex-module="users" class="q-mt-sm" />
        </div>
      </q-card-section>
      <user-table />
      <reset-password-form />
      <delete-confirm vuex-module="users" 
        :ok-button-text="$t('user_deactivate').split(' ')[0]" 
        :custom-text="$t('user_deactivate_confirm')" 
        action="deactivate" />
    </q-card>
  </div>
</template>

<script>
import { computed } from 'vue'
import { wrapperPadding, titleSpacing } from 'src/composables/screen'
import UserType from './UserType.vue'
import UserTable from './UserTable.vue'
import ResetPasswordForm from './ResetPasswordForm.vue'

export default {
  components: {
    UserType,
    UserTable,
    ResetPasswordForm
  },
  setup() {
    return { wrapperPadding, titleSpacing }
  }
}
</script>
