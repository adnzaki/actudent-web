<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated :class="header">
      <q-toolbar>
        <q-btn flat @click="drawer = !drawer" round dense icon="menu" />
        <q-toolbar-title>Actudent-v2 (Build {{ buildVersion }})</q-toolbar-title>
        <toggle-mode />
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
        :breakpoint="400"
    >
      <admin-menu />
      <q-img class="absolute-top" :src="avatarBg" style="height: 150px">
        <div class="absolute-bottom bg-transparent">
          <q-avatar size="56px" class="q-mb-sm">
            <img src="https://cdn.quasar.dev/img/boy-avatar.png">
          </q-avatar>
          <div class="text-weight-bold">{{ pengguna.user_name }}</div>
          <div>{{ pengguna.user_email }}</div>
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
import { conf } from '../composables/common'
import ToggleMode from 'components/ToggleMode.vue'
import { headerColor } from '../composables/mode'
import AdminMenu from './AdminMenu.vue'
import { pengguna, getPengguna } from '../composables/common'
import SubscriptionWarning from './SubscriptionWarning.vue'
import { menuWidth } from '../composables/screen'

export default defineComponent({
  name: 'MainLayout',
  data() {
    return {
      otherActions: []  
    }
  },
  provide() {
    return {
      textLang: computed(() => this.lang)
    }
  },
  mounted() {
    setTimeout(() => {
      setTimeout(() => {
        this.otherActions = [
          { link: '', icon: 'manage_accounts', label: this.$t('navbar_profil'), action: () => {} },
          { link: '', icon: 'school', label: this.$t('navbar_sekolah'), action: () => {} },
          { link: '', icon: 'logout', label: this.$t('navbar_keluar'), action: () => this.logout() },
        ]
      }, 1000);
    }, 1000);
  },
  components: {
    ToggleMode, AdminMenu,
    SubscriptionWarning
  },
  methods: {
    logout() {
      this.$q.cookies.remove(conf.cookieName)
      this.$q.cookies.remove(conf.userType)
      window.location.href = conf.loginUrl()
    }
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

    return {
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
