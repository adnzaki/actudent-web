<template>
  <q-layout view="hHh lpR fFf">

    <q-page-container class="bg-login">
      <q-page-sticky position="top-right" :offset="[40, 18]">
        <q-btn-group>
          <q-btn :color="getBtnClass('indonesia')" @click="switchLanguage('indonesia')" label="ID" />
          <q-btn :color="getBtnClass('english')" @click="switchLanguage('english')" label="EN" />
        </q-btn-group>
      </q-page-sticky>
      <div class="q-pa-md q-mt-md row items-start q-gutter-md">
        <q-card class="auth-box col-md-4 col-sm-8 offset-md-4 offset-sm-2">
          <q-card-section>
            <q-img
              src="../../public/icons/icon-512x512.png" 
              width="20%" :ratio="1"
              class="app-logo" />
            <p class="text-center text-uppercase q-pt-lg q-pb-sm">{{ $t('silakan_login') }}</p>
            <q-form class="q-gutter-xs">
              <q-input class="auth-input q-mb-lg" standout="auth-input-focus text-black" v-model="username" label="Username">
                <template v-slot:prepend>
                  <q-icon name="mail_outline" color="primary" />
                </template>
              </q-input>
              <q-input class="auth-input q-mb-xs" type="password" 
                standout="auth-input-focus text-black" v-model="password" label="Password">
                <template v-slot:prepend>
                  <q-icon name="vpn_key" color="primary" />
                </template>
              </q-input>

              <q-checkbox class="q-mb-lg" v-model="rememberMe" :label="$t('remember_me')" />

              <q-btn color="blue" :style="btnStyle">{{ $t('login') }}</q-btn>

            </q-form>
          </q-card-section>
        </q-card>
        <div class="col-md-4 col-sm-8 offset-md-4 offset-sm-2">
          
          <q-img
            src="../../public/company-logo.png" 
            width="40%"
            style="left: 30%" />

        </div>
      </div>
    </q-page-container>

  </q-layout>
</template>
<script>
import { ref, reactive } from 'vue'

export default {
  name: 'Login',
  setup() {
    const userLang = localStorage.getItem('ac_userlang')
    const btnLangColor = ref({
      active: 'accent',
      inactive: 'purple-5'
    })

    return {
      getBtnClass(lang) {
        if(userLang === lang || (userLang === null && lang === 'indonesia')) {
          return btnLangColor.value.active
        } else {
          return btnLangColor.value.inactive
        }
      },
      switchLanguage(lang) {
        localStorage.setItem('ac_userlang', lang)
        window.location.reload()
      },
      rememberMe: false,
      btnStyle: reactive({
        fontSize: '18px',
        width: 'calc(100% - 5px)',
        borderRadius: '5px'
      }),
      username: ref(''),
      password: ref('')
    }
  }
}
</script>