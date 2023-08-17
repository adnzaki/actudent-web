<template>
  <q-card class="my-card q-pb-sm q-mt-md">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">
        {{ $t('user_change_title') }}
      </div>
      <div class="text-h6 text-capitalize" v-else>
        {{ $t('user_change_title') }}
      </div>

      <q-form class="q-gutter-xs q-mt-md">
        <q-input
          outlined
          :label="$t('user_old_password')"
          dense
          v-model="formData.old_password"
          type="password"
        />
        <ac-error :label="error.old_password" />

        <q-input
          outlined
          :label="$t('user_newPass')"
          dense
          v-model="formData.user_password"
          type="password"
        />
        <ac-error :label="error.user_password" />

        <q-input
          outlined
          :label="$t('user_newPass_confirm')"
          dense
          v-model="formData.user_password_confirm"
          type="password"
        />
        <ac-error :label="error.user_password_confirm" />
      </q-form>

      <q-card-actions align="left">
        <q-btn
          :label="$t('simpan')"
          :disable="disableSaveButton"
          @click="save"
          color="primary"
          padding="8px 20px"
          class="q-mt-md"
        />
      </q-card-actions>
    </q-card-section>
  </q-card>
</template>

<script>
import { ref, computed } from 'vue'
import { titleSpacing } from 'src/composables/screen'
import { useUserStore } from 'src/stores/user'
import {
  admin,
  createFormData,
  bearerToken,
  t,
  timeout,
} from 'src/composables/common'
import { useQuasar } from 'quasar'

export default {
  setup() {
    const store = useUserStore()
    const $q = useQuasar()

    const formData = ref({
      old_password: '',
      user_password: '',
      user_password_confirm: '',
    })

    const save = () => {
      store.helper.disableSaveButton = true
      const progress = $q.notify({
        group: false,
        spinner: true,
        message: t('user_change_progress'),
        color: 'info',
        position: 'center',
        timeout: 0,
      })

      admin
        .post('change-password', formData.value, {
          headers: { Authorization: bearerToken },
          transformRequest: [(data) => createFormData(data)],
        })
        .then(({ data }) => {
          progress({ timeout })
          store.helper.disableSaveButton = false
          if (data.code === 200) {
            store.error = {}
            progress({
              message: `${t('sukses')} ${t('user_change_success')}`,
              color: 'positive',
              icon: 'done',
              spinner: false,
            })

            formData.value = {
              old_password: '',
              user_password: '',
              user_password_confirm: '',
            }
          } else {
            store.error = data.msg
            if (data.code === 500) {
              progress({
                message: `Error! ${t('user_error_text')}`,
                color: 'negative',
                spinner: false,
              })
            } else if (data.code === 503) {
              progress({
                message: `Error! ${t('user_password_wrong')}`,
                color: 'negative',
                spinner: false,
              })
            }
          }
        })
    }

    return {
      save,
      store,
      formData,
      titleSpacing,
      error: computed(() => store.error),
      disableSaveButton: computed(() => store.helper.disableSaveButton),
    }
  },
}
</script>
