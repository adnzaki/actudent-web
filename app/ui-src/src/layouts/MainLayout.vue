<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated :class="header">
      <q-toolbar>
        <q-btn flat @click="drawer = !drawer" round dense icon="menu" />
        <q-toolbar-title class="mobile-hide"
          ><strong>SiAbsen</strong> | SMKN 11 Kota Bekasi</q-toolbar-title
        >
        <q-toolbar-title class="mobile-only"
          ><strong>SiAbsen</strong> |</q-toolbar-title
        >
        <!-- Notification button here -->
        <q-btn flat round dense icon="account_circle">
          <q-menu>
            <q-list separator>
              <other-actions
                icon="o_manage_accounts"
                :label="$t('navbar_profil')"
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
            <img src="/boy-avatar.png" />
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
import { defineComponent, ref, onMounted, computed, watch, reactive } from 'vue'
import { baseUrl } from '../../globalConfig'
import { headerColor } from '../composables/mode'
import { conf, pengguna, getPengguna } from '../composables/common'
import { menuWidth } from '../composables/screen'
import AppMenu from './AppMenu.vue'
import SubscriptionWarning from './SubscriptionWarning.vue'
import { useQuasar } from 'quasar'
import OtherActions from './OtherActions.vue'
import { useSiabsenStore } from 'src/stores/siabsen'

export default defineComponent({
  name: 'MainLayout',
  components: {
    AppMenu,
    SubscriptionWarning,
    OtherActions,
  },
  setup() {
    const $q = useQuasar()
    const store = useSiabsenStore()
    const avatarBg = `${baseUrl()}images/bg/wp-4.jpg`
    const header = ref('')
    function triggerHeader() {
      if (headerColor.value === 'dark') {
        header.value = 'bg-grey-10'
      } else {
        header.value = 'bg-blue'
      }
    }

    onMounted(triggerHeader)

    onMounted(getPengguna)

    watch(headerColor, triggerHeader)

    const userAction = ref(false)
    const hideUserAction = () => {
      userAction.value = false
    }

    onMounted(() => {
      if ($q.cookies.get(conf.userType) === '1') {
        store.getPermissionNotif()
        setInterval(() => {
          store.getPermissionNotif()
        }, 15 * 60 * 1000) // notify admin every 15 minutes
      }
    })

    return {
      logout() {
        $q.cookies.remove(conf.cookieName, { path: '/' })
        $q.cookies.remove(conf.userType, { path: '/' })
        localStorage.removeItem('class')
        localStorage.removeItem('date')
        localStorage.removeItem('grade_id')
        localStorage.removeItem('lesson')
        window.location.reload()
      },
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
