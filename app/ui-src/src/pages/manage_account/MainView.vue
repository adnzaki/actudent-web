<template>
  <div :class="wrapperPadding()">
    <q-card class="my-card q-pb-sm q-mt-md">
      <q-card-section
        ><div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">
          {{ $t('user_manage_account') }}
        </div>
        <div class="text-h6 text-capitalize" v-else>
          {{ $t('user_manage_account') }}
        </div>
        <q-list bordered class="q-mt-md" separator>
          <q-item clickable v-ripple to="/account">
            <q-item-section avatar>
              <q-icon name="o_manage_accounts" />
            </q-item-section>

            <q-item-section>{{ $t('navbar_profil') }}</q-item-section>
          </q-item>

          <q-item clickable v-ripple to="/sessions">
            <q-item-section avatar>
              <q-icon name="o_dns" />
            </q-item-section>

            <q-item-section>{{ $t('session_title') }}</q-item-section>
          </q-item>
          <!-- <q-item clickable v-ripple to="/contribution">
            <q-item-section avatar>
              <q-icon name="o_favorite" />
            </q-item-section>

            <q-item-section>{{ $t('menu_kontribusi') }}</q-item-section>
          </q-item> -->
        </q-list>

        <q-btn
          class="q-mt-lg"
          round
          icon="logout"
          color="negative"
          :label="$t('navbar_keluar')"
          style="width: 100%"
          @click="logout()"
        />
      </q-card-section>
    </q-card>
  </div>
</template>

<script setup>
import { inject } from 'vue'
import { wrapperPadding } from 'src/composables/screen'

const logout = inject('logout')
</script>
