<template>
  <q-layout view="lHh Lpr lFf">
    <q-header :elevated="elevated" :class="header">
      <q-toolbar>
        <q-btn flat @click="drawer = !drawer" round dense icon="menu" />
        <q-toolbar-title>ActudentV2 </q-toolbar-title>
        <!-- Notification button here -->
        <q-btn flat round dense icon="account_circle" class="mobile-hide">
          <q-menu :class="userMenu">
            <q-list separator>
              <other-actions
                icon="o_manage_accounts"
                :label="$t('navbar_profil')"
                link="/account"
              />
              <other-actions
                icon="o_dns"
                :label="$t('session_title')"
                link="/sessions"
              />
              <!-- <other-actions icon="o_school" :label="$t('navbar_sekolah')" /> -->
              <other-actions
                icon="logout"
                :label="$t('navbar_keluar')"
                @click="logout"
              />
            </q-list>
          </q-menu>
        </q-btn>
      </q-toolbar>
    </q-header>

    <mobile-menu />

    <q-drawer
      v-model="drawer"
      show-if-above
      :width="menuWidth()"
      :breakpoint="450"
    >
      <app-menu />
      <q-img class="absolute-top" :src="avatarBg" style="height: 150px">
        <div class="absolute-bottom bg-transparent">
          <q-avatar size="56px" class="q-mb-sm">
            <img src="boy-avatar.png" />
          </q-avatar>
          <div class="text-weight-bold">{{ pengguna.user_name }}</div>
          <div class="mobile-hide">{{ $trim(pengguna.user_email, 25) }}</div>
          <div class="mobile-only">{{ $trim(pengguna.user_email, 30) }}</div>
        </div>
      </q-img>
    </q-drawer>

    <q-page-container>
      <subscription-warning />
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import { defineComponent, ref, onMounted, provide, watch, reactive } from 'vue'
import { baseUrl } from '../../globalConfig'
import {
  headerColor,
  header,
  elevated,
  userMenu,
  triggerHeader,
} from '../composables/mode'
import {
  conf,
  pengguna,
  getPengguna,
  axios,
  bearerToken,
} from '../composables/common'
import { menuWidth } from '../composables/screen'
import AppMenu from './AppMenu.vue'
import SubscriptionWarning from './SubscriptionWarning.vue'
import { useQuasar } from 'quasar'
import OtherActions from './OtherActions.vue'
import MobileMenu from './MobileMenu.vue'

export default defineComponent({
  name: 'MainLayout',
  components: {
    AppMenu,
    SubscriptionWarning,
    OtherActions,
    MobileMenu,
  },
  setup() {
    const $q = useQuasar()
    const avatarBg = `${baseUrl()}images/bg/wp-4.jpg`
    // const header = ref('')
    // const elevated = ref(true)
    // const userMenu = ref(['user-menu'])

    // function triggerHeader() {
    //   if (headerColor.value === 'dark') {
    //     header.value = 'bg-grey-10'
    //     elevated.value = false
    //     userMenu.value.push('user-menu-dark')
    //   } else {
    //     header.value = 'header-gradient'
    //     elevated.value = true
    //     userMenu.value.pop()
    //   }
    // }

    onMounted(triggerHeader)

    onMounted(getPengguna)

    watch(headerColor, triggerHeader)

    const userAction = ref(false)
    const hideUserAction = () => {
      userAction.value = false
    }

    const logout = () => {
      axios
        .get(`${conf.coreAPI}logout`, {
          headers: { Authorization: bearerToken },
        })
        .then(({ data }) => {
          if (data.status === 'OK') {
            $q.cookies.remove(conf.cookieName, { path: '/' })
            $q.cookies.remove(conf.userType, { path: '/' })
            localStorage.removeItem('class')
            localStorage.removeItem('date')
            localStorage.removeItem('grade_id')
            localStorage.removeItem('lesson')
            window.location.reload()
          } else {
            console.warn(data.msg)
          }
        })
    }

    provide('logout', logout)

    return {
      logout,
      userMenu,
      elevated,
      drawer: ref(false),
      userAction,
      hideUserAction,
      avatarBg,
      header,
      pengguna,
      menuWidth,
    }
  },
})
</script>
