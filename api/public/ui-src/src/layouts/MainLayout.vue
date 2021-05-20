<template>
  <q-layout view="lHh Lpr lFf">
    <toggle-mode />
    <q-header elevated :class="header">
      <q-toolbar>
        <q-toolbar-title>Actudent-v2</q-toolbar-title>
        <q-btn flat @click="drawer = !drawer" round dense icon="menu" />
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="drawer"
        show-if-above
        :width="200"
        :breakpoint="400"
    >
      <q-scroll-area style="height: calc(100% - 150px); margin-top: 150px; border-right: 1px solid #ddd">
        <q-list padding>
          <q-item clickable v-ripple to="/home">
              <q-item-section avatar>
                <q-icon name="home" />
              </q-item-section>

              <q-item-section>
                {{ lang.menu_dashboard }}
              </q-item-section>
          </q-item>

          <q-item clickable v-ripple to="/parent">
            <q-item-section avatar>
              <q-icon name="star" />
            </q-item-section>

            <q-item-section>
              {{ lang.menu_parent }}
            </q-item-section>
          </q-item>
        
        </q-list>
      </q-scroll-area>
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
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>

import { defineComponent, ref, onMounted, watch } from 'vue'
import getPengguna from '../mixins/get-pengguna'
import locale from '../mixins/fetch-lang'
import { baseUrl } from '../../globalConfig'
import ToggleMode from 'components/ToggleMode'
import { headerColor } from '../composables/mode'

export default defineComponent({
  name: 'MainLayout',

  mixins: [getPengguna, locale],
  mounted() {
    setTimeout(() => {
      this.fetchLang('Admin')
    }, 1000)
    this.getPengguna()
  },
  components: {
    ToggleMode
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

    return {
      drawer: ref(false),
      avatarBg,
      header
    }
  }
})
</script>
