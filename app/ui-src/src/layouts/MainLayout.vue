<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated :class="header">
      <q-toolbar>
        <q-btn flat @click="drawer = !drawer" round dense icon="menu" />
        <q-toolbar-title class="mobile-hide"><strong>SiAbsen</strong> | SMKN 11 Kota Bekasi</q-toolbar-title>
        <q-toolbar-title class="mobile-only"><strong>SiAbsen</strong> |</q-toolbar-title>
        <!-- Notification button here -->
        <q-btn flat round dense icon="account_circle">
          <q-menu>
            <q-list separator>
              <q-item v-for="(item, key) in otherActions" :key="key" 
                clickable v-ripple class="q-pr-xl"
                :to="item.link"
                @click="item.action()"
                v-close-popup>
                <q-item-section avatar>
                  <q-icon :name="item.icon" />
                </q-item-section>
                <q-item-section>
                  {{ item.label }}
                </q-item-section>
              </q-item>
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
            <img src="../../public/boy-avatar.png">
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

import { defineComponent, ref, onMounted, computed, watch } from 'vue'
import { baseUrl } from '../../globalConfig'
import { headerColor } from '../composables/mode'
import { conf, pengguna, getPengguna } from '../composables/common'
import { menuWidth } from '../composables/screen'
import AppMenu from './AppMenu.vue'
import SubscriptionWarning from './SubscriptionWarning.vue'
import { useQuasar } from 'quasar'

export default defineComponent({
  name: 'MainLayout',
  data() {
    return {
      otherActions: []  
    }
  },
  mounted() {
    setTimeout(() => {
      setTimeout(() => {
        this.otherActions = [
          { link: '', icon: 'o_manage_accounts', label: this.$t('navbar_profil'), action: () => {} },
          { link: '', icon: 'o_school', label: this.$t('navbar_sekolah'), action: () => {} },
          { link: '', icon: 'logout', label: this.$t('navbar_keluar'), action: () => this.logout() },
        ]
      }, 1000);
    }, 1000);
  },
  components: {
    AppMenu,
    SubscriptionWarning
  },
  setup () {
    const avatarBg = `${baseUrl()}images/bg/wp-4.jpg`
    const header = ref('')
    function triggerHeader() {
      if(headerColor.value === 'dark') {
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

    const store = useStore()
    const $q = useQuasar()
    onMounted(() => {
      if($q.cookies.get(conf.userType) === '1') {
        setInterval(() => {
          store.dispatch('siabsen/getPermissionNotif')
        }, 15 * 60 * 1000) // notify admin every 15 minutes
      }
    })

    return {
      logout() {
        $q.cookies.remove(conf.cookieName)
        $q.cookies.remove(conf.userType)
        localStorage.removeItem('class')
        localStorage.removeItem('date')
        localStorage.removeItem('grade_id')
        localStorage.removeItem('lesson')
        // window.location.href = conf.loginUrl()
        window.location.reload()
      },
      drawer: ref(false),
      userAction,
      hideUserAction,
      avatarBg,
      header,
      pengguna,
      menuWidth
    }
  }
})
</script>
