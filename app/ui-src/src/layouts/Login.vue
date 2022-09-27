<template>
  <q-layout view="hHh lpR fFf">

    <q-page-container :class="['bg-login', styleSelector('bgImage')]">
      <div class="q-pa-md q-mt-md row items-start q-gutter-md">
        <q-card :class="['auth-box col-md-4 col-sm-8 offset-md-4 offset-sm-2', styleSelector('card')]">
          <q-card-section>
            <q-img
              :src="brandLogo" 
              width="30%" :ratio="1"
              class="app-logo" />
            <p :class="['text-center text-uppercase q-pt-lg', pleaseLoginText]">{{ $t('silakan_login') }}</p>
            <q-form class="q-gutter-xs" @submit.prevent="validate">

              <!-- <q-input :class="['q-pl-md', usernameSpacing, styleSelector('input')]" borderless :color="styleSelector('icon')"
                v-model="username" label="Username / NIK" :input-class="styleSelector('inputColor')" 
                :label-color="styleSelector('label')" @keyup.enter="validate">
                <template v-slot:prepend>
                  <q-icon name="mail_outline" />
                </template>
              </q-input> -->

              <q-input filled class="q-mb-md"
                v-model="username" :label="usernameLabel" 
                @keyup.enter="validate"
                :label-color="styleSelector('label')"
                :color="styleSelector('icon')">
                <template v-slot:prepend>
                  <q-icon name="mail_outline" />
                </template>
              </q-input>

              <!-- <q-input :class="['q-pl-md q-mb-xs', styleSelector('input')]" type="password" :color="styleSelector('icon')"
                borderless v-model="password" label="Password" :label-color="styleSelector('label')"
                :input-class="styleSelector('inputColor')"  @keyup.enter="validate">
                <template v-slot:prepend>
                  <q-icon name="vpn_key" :color="styleSelector('icon')" />
                </template>
              </q-input> -->

              <q-input type="password" filled
                v-model="password" label="Password"
                @keyup.enter="validate"
                :label-color="styleSelector('label')">
                <template v-slot:prepend>
                  <q-icon name="vpn_key" />
                </template>
              </q-input>

              <q-checkbox color="primary" keep-color class="q-mb-md" v-model="rememberMe" :label="$t('remember_me')" />
              <p v-if="showMsg" style="margin-top: -20px" :class="`text-bold text-${msgClass}`">{{ msg }}</p>
              <q-btn :color="styleSelector('btn')" @click="validate" :style="btnStyle">{{ $t('login') }}</q-btn>
            </q-form>
          </q-card-section>
        </q-card>
        <div id="company-logo" class="col-12 col-md-4 col-sm-8 offset-md-4 offset-sm-2">
          
          <q-img
            :class="styleSelector('poweredLogo')"
            src="../../public/company-logo.png" 
            width="40%"
            :style="companyLogoPushLeft" />

        </div>
      </div>
    </q-page-container>

  </q-layout>
</template>

<script>
import { ref, reactive, computed } from 'vue'
import { axios } from 'boot/axios'
import { t, conf, createFormData, isAuthenticated, userType } from 'src/composables/common'
import { useQuasar } from 'quasar'

export default {
  name: 'Login',
  beforeRouteEnter(to, from, next) {
    let url = '/login'
    if(userType === '1') url = '/home'
    else if(userType === '2') url = '/teacher/home'
    
    if(to.path === '/login' && isAuthenticated) next({ path: url })
    else next()
  },
  setup() {
    const $q = useQuasar()
    const userLang = localStorage.getItem(conf.userLang)

    const username = ref(''),
          password = ref(''),
          error = ref({}),
          msg = ref(''),
          msgClass = ref('black'),
          showMsg = ref(false),
          rememberMe = ref(false)
  
    return {
      usernameLabel: computed(() => `Username / NIG (${t('login_nig')})`),
      conf,
      companyLogoPushLeft: $q.screen.lt.sm ? 'left: 27%' : 'left: 30%',
      styleSelector(style) {
        const styles = {
          light: {
            bgImage: 'bg-img-light',
            card: '',
            icon: 'primary',
            label: '',
            input: 'auth-input',
            inputColor: 'input-color',
            btn: 'blue',
            poweredLogo: 'powered-style',
          },
          dark: {
            bgImage: 'bg-img-dark',
            card: 'auth-box-dark',
            icon: 'blue-1',
            label: 'blue-1',
            input: 'auth-input-dark',
            inputColor: 'input-color-dark',
            btn: 'cyan-10',
            poweredLogo: ''
          }
        }
        
        return $q.cookies.get('theme') === 'dark' 
          ? styles.dark[style]
          : styles.light[style]
      },
      validate() {
        msg.value = ''
        showMsg.value = true
        const hideMsg = () => showMsg.value = false

        if(username.value === '' || password.value === '') {
          msg.value = t('userpassword_wajib')
          msgClass.value = 'negative'
          setTimeout(hideMsg, 6000)
        } else {
          const postData = {
            username: username.value,
            password: password.value,
          }

          msg.value = t('mengautentikasi')
          msgClass.value = $q.cookies.get('theme') === 'dark' ? 'white' :'black'

          // do request..
          axios.post(`${conf.coreAPI}login/validasi`, postData, {
            transformRequest: [data => createFormData(data)]
          })
            .then(response => {
              const res = response.data
              if(res.msg === 'expired') {
                msgClass.value = 'negative'
                msg.value = res.note
              } else {
                if(res.msg === 'valid') {
                  msg.value = t('login_sukses')
                  msgClass.value = 'positive'

                  const dt = new Date(),
                        now = dt.getTime(),
                        expMs = now + conf.cookieExp,
                        exp = new Date(expMs),
                        cookieOptions = {
                          expires: exp.toUTCString(),
                          path: '/',
                          sameSite: 'None',
                          secure: true
                        }

                  $q.cookies.set(conf.cookieName, res.token, cookieOptions)
                  $q.cookies.set(conf.userType, res.level, cookieOptions)

                  // always re-set the language after login successful
                  localStorage.setItem(conf.userLang, res.lang)

                  // redirect to dashboard depend on user type...
                  if(res.level === '1') {
                    window.location.href = conf.homeUrl()
                    localStorage.removeItem('grade_id')
                  } else if(res.level === '2' || res.level === '0') {
                    localStorage.setItem('grade_id', res.grade);
                    window.location.href = conf.teacherHomeUrl()
                  }
                } else if(res.msg === 'unauthorized') {
                  msgClass.value = 'negative'
                  msg.value = t('salah_akses')

                  setTimeout(hideMsg, 8000)
                } else {
                  msgClass.value = 'negative'
                  msg.value = t('invalid_login')

                  setTimeout(hideMsg, 4000)
                }
              }
            })
        }
      },
      username, password, error, msg, msgClass, showMsg, rememberMe,
      btnStyle: reactive({
        fontSize: '18px',
        width: 'calc(100% - 5px)',
        borderRadius: $q.screen.lt.sm ? '28px' : '5px'
      }),
      cardTopSpacing: $q.screen.gt.md ? 'q-mt-lg' : 'q-mt-xs',
      usernameSpacing: $q.screen.lt.sm ? 'q-mb-lg' : 'q-mb-md',
      pleaseLoginText: $q.screen.lt.sm ? 'q-pb-sm' : '',
      brandLogo: computed(() => {
        let logo
        if($q.cookies.get('theme') === 'dark') {
          logo = 'siabsen-logo-white'
        } else {
          logo = 'siabsen-logo'
        }

        return require(`../../public/${logo}.png`)
      }),      
    }
  }
}
</script>