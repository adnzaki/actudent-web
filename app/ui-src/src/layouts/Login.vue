<template>
  <q-layout view="hHh lpR fFf">
    <q-page-container :class="['bg-login', styleSelector('bgImage')]">
      <!-- <div class="q-pa-md q-gutter-sm" v-if="showUpdateProgress">
        <q-banner
          inline-actions
          rounded
          :class="[progressColor, 'text-white text-center']"
        >
          <strong> {{ dbProgressText }} </strong>

        </q-banner>
      </div> -->

      <div class="q-pa-md q-mt-md row items-start q-gutter-md">
        <q-card
          :class="[
            'auth-box col-md-4 col-sm-8 offset-md-4 offset-sm-2',
            styleSelector('card'),
          ]"
        >
          <q-card-section>
            <q-img
              src="../../public/icons/icon-512x512.png"
              width="20%"
              :ratio="1"
              class="app-logo"
            />
            <p class="text-center text-uppercase q-pt-lg q-pb-sm">
              {{ $t('silakan_login') }}
            </p>
            <q-form class="q-gutter-xs" @submit.prevent="store.validate">
              <q-input
                filled
                class="q-mb-md"
                v-model="store.username"
                :label="usernameLabel"
                @keyup.enter="store.validate"
                :label-color="styleSelector('label')"
                :color="styleSelector('icon')"
                :disable="dbUpdate"
              >
                <template v-slot:prepend>
                  <q-icon name="mail_outline" />
                </template>
              </q-input>

              <q-input
                type="password"
                filled
                v-model="store.password"
                label="Password"
                @keyup.enter="store.validate"
                :label-color="styleSelector('label')"
                :disable="dbUpdate"
              >
                <template v-slot:prepend>
                  <q-icon name="vpn_key" />
                </template>
              </q-input>

              <!-- <q-checkbox
                color="primary"
                keep-color
                class="q-mb-lg"
                v-model="rememberMe"
                :label="$t('remember_me')"
              /> -->
              <p
                v-if="store.showMessage"
                :class="`text-bold text-${store.messageClass} q-mt-md`"
              >
                {{ store.message }}
              </p>
              <q-btn
                :color="styleSelector('btn')"
                @click="store.validate"
                :style="btnStyle"
                :disable="dbUpdate"
                class="q-mt-lg"
                >{{ $t('login') }}</q-btn
              >
            </q-form>
          </q-card-section>
        </q-card>
        <div
          id="company-logo"
          class="col-12 col-md-4 col-sm-8 offset-md-4 offset-sm-2"
        >
          <q-img
            :class="styleSelector('poweredLogo')"
            src="../../public/company-logo.png"
            width="40%"
            :style="companyLogoPushLeft"
          />
        </div>
      </div>
    </q-page-container>
  </q-layout>
</template>

<script>
import { ref, reactive, computed, onMounted } from 'vue'
import { axios } from 'boot/axios'
import { t, conf, isAuthenticated, userType } from 'src/composables/common'
import { useQuasar } from 'quasar'
import { useLoginStore } from 'src/stores/login-store'

export default {
  name: 'LoginPage',
  beforeRouteEnter(to, from, next) {
    let url = '/login'
    if (userType === '1') url = '/home'
    else if (userType === '2' || userType === '0') url = '/teacher/home'
    else if (userType === '3') url = '/student/home'

    if (to.path === '/login' && isAuthenticated.value) next({ path: url })
    else next()
  },
  setup() {
    const $q = useQuasar()
    const store = useLoginStore()
    const userLang = localStorage.getItem(conf.userLang)
    // const dbUpdate = ref(true)
    // const showUpdateProgress = ref(true)
    // const progressColor = ref('bg-red')
    // // const dbProgressText = ref(t('db_check'))
    // const dbProgressText = ref('Checking database...')

    store.updateDb()

    const error = computed(() => store.error)

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
            poweredLogo: '',
          },
        }

        return $q.cookies.get('theme') === 'dark'
          ? styles.dark[style]
          : styles.light[style]
      },
      error,
      // msg,
      store,
      // dbUpdate,
      // progressColor,
      // showUpdateProgress,
      // dbProgressText,
      btnStyle: reactive({
        fontSize: '18px',
        width: 'calc(100% - 5px)',
        borderRadius: $q.screen.lt.sm ? '28px' : '5px',
      }),
    }
  },
}
</script>
