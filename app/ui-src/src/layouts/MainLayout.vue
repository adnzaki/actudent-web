<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated :class="header">
      <q-toolbar>
        <q-btn flat @click="drawer = !drawer" round dense icon="menu" />
        <q-toolbar-title>Actudent-v2</q-toolbar-title>
        <toggle-mode />
        <q-btn flat round dense icon="account_circle">
          <q-menu>
            <q-list bordered separator class="bg-white">
              <q-item v-for="(item, key) in otherActions" :key="key" 
                clickable v-ripple class="q-pr-xl"
                :to="item.link"
                @click="item.action"
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
        :width="230"
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
    
    <!-- <q-page-sticky
      v-if="userAction"
      position="top-right" 
      :offset="[20, 0]" 
      style="z-index: 9999 !important;">
      <q-list bordered separator class="bg-white">
        <q-item v-for="(item, key) in otherActions" :key="key" 
          clickable v-ripple class="q-pr-xl"
          :to="item.link"
          @click="item.action"
          v-close-popup>
          <q-item-section avatar>
            <q-icon :name="item.icon" />
          </q-item-section>
          <q-item-section>
            {{ item.label }}
          </q-item-section>
        </q-item>
      </q-list>
    </q-page-sticky> -->
    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>

import { defineComponent, ref, onMounted, watch } from 'vue'
import getPengguna from '../mixins/get-pengguna'
import { baseUrl } from '../../globalConfig'
import ToggleMode from 'components/ToggleMode'
import { headerColor } from '../composables/mode'
import AdminMenu from './AdminMenu'
import locale from '../mixins/fetch-lang'

export default defineComponent({
  name: 'MainLayout',
  mixins: [getPengguna, locale],
  data() {
    return {
      otherActions: []  
    }
  },
  mounted() {
    this.getPengguna()
    setTimeout(() => {
      this.fetchLang('Admin')
      setTimeout(() => {
        this.otherActions = [
          { link: '', icon: 'manage_accounts', label: this.lang.navbar_profil, action: '' },
          { link: '', icon: 'school', label: this.lang.navbar_sekolah, action: '' },
          { link: '', icon: 'logout', label: this.lang.navbar_keluar, action: '' },
        ]
      }, 1000);
    }, 1000);
  },
  components: {
    ToggleMode, AdminMenu
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
      header
    }
  }
})
</script>
