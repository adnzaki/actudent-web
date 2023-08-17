<template>
  <q-card class="my-card q-pb-sm q-mt-md">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">
        {{ $t('user_token_access') }}
      </div>
      <div class="text-h6 text-capitalize" v-else>
        {{ $t('user_token_access') }}
      </div>
      <div :class="['row', titleSpacing()]">
        <p class="text-bold text-negative">{{ $t('user_token_warning') }}</p>
      </div>

      <q-input
        outlined
        :label="$t('user_token_access')"
        dense
        v-model="token"
        type="password"
        readonly
      />

      <q-card-actions align="left">
        <q-btn
          :label="$t('user_copy_token')"
          @click="copyToken"
          color="primary"
          padding="8px 20px"
          class="q-mt-md"
        />
      </q-card-actions>
    </q-card-section>
  </q-card>
</template>

<script>
import { ref } from 'vue'
import { titleSpacing } from 'src/composables/screen'
import { copyToClipboard, useQuasar } from 'quasar'
import { Cookies, conf, timeout, t } from 'src/composables/common'

export default {
  setup() {
    const $q = useQuasar()
    const token = Cookies.get(conf.cookieName)

    const copyToken = () => {
      copyToClipboard(token)
        .then(() => {
          $q.notify({
            color: 'positive',
            icon: 'done',
            message: t('user_token_copied'),
            timeout,
            position: 'center',
          })
        })
        .catch(() => {
          // fail
        })
    }

    return {
      token,
      copyToken,
      titleSpacing,
    }
  },
}
</script>
