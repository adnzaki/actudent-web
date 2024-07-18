<template>
  <q-card class="my-card q-pb-sm q-my-md">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">
        {{ $t('switch_account') }}
      </div>
      <div class="text-h6 text-capitalize" v-else>
        {{ $t('switch_account') }}
      </div>

      <q-list
        bordered
        separator
        v-if="store.siblings.length > 0"
        class="q-mt-md"
      >
        <q-item v-for="(item, index) in store.siblings" :key="index">
          <q-item-section avatar>
            <q-avatar color="primary" text-color="white">
              {{ item.student_name.substr(0, 1) }}
            </q-avatar>
          </q-item-section>
          <q-item-section>
            <q-item-label>{{ item.student_name }}</q-item-label>
            <q-item-label caption lines="1"
              >NIS: {{ item.student_nis }}</q-item-label
            >
          </q-item-section>
          <q-item-section side>
            <q-btn
              icon="login"
              :class="addButton"
              @click="switchAccount(item.student_nis)"
              ><btn-tooltip label="Login"
            /></q-btn>
          </q-item-section>
        </q-item>
      </q-list>
    </q-card-section>
  </q-card>
</template>

<script setup>
import { useMonitoringStore } from 'src/stores/monitoring'
import { useLoginStore } from 'src/stores/login-store'
import { addButton } from 'src/composables/common'

const store = useMonitoringStore()
const loginStore = useLoginStore()

const switchAccount = (username) => {
  loginStore.username = username
  loginStore.password = 'switch account'
  loginStore.requirePassword = 0
  loginStore.validate()
}

store.getSiblings()
</script>
