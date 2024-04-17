<template>
  <div class="q-pa-md q-mb-md">
    <q-list
      bordered
      separator
      v-for="(item, index) in store.sessions"
      :key="index"
    >
      <q-item clickable>
        <q-item-section>
          <q-item-label>{{ item.platform }}</q-item-label>
          <q-item-label caption>{{ item.browser }}</q-item-label>
        </q-item-section>

        <q-item-section side>
          <q-btn
            :class="actionButton"
            icon="delete"
            v-if="item.is_main_session === '0'"
            @click="store.showDeleteConfirm(item.login_id)"
          >
            <btn-tooltip :label="$t('session_revoke')" />
          </q-btn>
          <q-badge color="blue" v-if="item.is_main_session === '1'">{{
            $t('main_session')
          }}</q-badge>
        </q-item-section>
      </q-item>
    </q-list>
  </div>
</template>

<script setup>
import { useSessionStore } from 'src/stores/sessions'
import { actionButton } from 'src/composables/common'

const store = useSessionStore()
store.getActiveSessions()
</script>
