<template>
  <q-layout view="hHh lpR fFf" class="bg-install">
    <q-page-container>
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
              Welcome to Actudent Database Installation page <br />
              <strong
                >This feature is intended to be used for developer only</strong
              >
            </p>
            <q-form class="q-gutter-xs" @submit.prevent="validate">
              <q-input
                filled
                v-model="store.postData.organization_name"
                label="School Name"
                :label-color="styleSelector('label')"
                :color="styleSelector('icon')"
              >
                <template v-slot:prepend>
                  <q-icon name="o_business" />
                </template>
              </q-input>
              <ac-error :label="store.error.organization_name" />

              <q-input
                filled
                v-model="store.postData.organization_origination"
                label="App URL"
                :label-color="styleSelector('label')"
                :color="styleSelector('icon')"
              >
                <template v-slot:prepend>
                  <q-icon name="link" />
                </template>
              </q-input>
              <ac-error :label="store.error.organization_origination" />

              <q-select
                filled
                v-model="store.postData.subscription_type"
                :options="options"
              >
                <template v-slot:prepend>
                  <q-icon name="bookmarks" />
                </template>
              </q-select>
              <ac-error :label="store.error.subscription_type" />

              <q-input
                filled
                v-model="store.postData.database_name"
                label="Database Name (for Android API)"
                :label-color="styleSelector('label')"
                :color="styleSelector('icon')"
              >
                <template v-slot:prepend>
                  <q-icon name="storage" />
                </template>
              </q-input>
              <ac-error :label="store.error.database_name" />

              <q-input
                filled
                v-model="store.postData.token"
                label="Developer Token"
                :label-color="styleSelector('label')"
                :color="styleSelector('icon')"
              >
                <template v-slot:prepend>
                  <q-icon name="vpn_key" />
                </template>
              </q-input>
              <ac-error :label="store.error.token" />

              <!-- <p
                v-if="store.showProgressMessage"
                style="margin-top: -20px"
                :class="`text-bold text-${msgClass}`"
              >
                {{ store.progressMessage }}
              </p> -->
              <q-btn
                :color="styleSelector('btn')"
                @click="store.validateForm"
                :style="btnStyle"
                :disable="store.disableButton"
                >Install</q-btn
              >
            </q-form>
          </q-card-section>
        </q-card>
      </div>
    </q-page-container>
  </q-layout>
</template>

<style lang="sass" scoped>
.bg-install
  background: rgb(79,134,201)
  background: linear-gradient(143deg, rgba(79,134,201,1) 22%, rgba(67,148,247,1) 49%, rgba(46,104,173,1) 89%)
  margin-top: -20px
  height: calc( 100vh + 20px )
</style>

<script setup>
import { useQuasar } from 'quasar'
import { ref, reactive } from 'vue'
import { useSetupStore } from 'src/stores/setup-store'

const $q = useQuasar()
const store = useSetupStore()
const validate = () => {}

const options = ['Free', 'Starter', 'Standard', 'Enhanced', 'Enterprise']

const btnStyle = reactive({
  fontSize: '18px',
  width: 'calc(100% - 5px)',
  borderRadius: $q.screen.lt.sm ? '28px' : '5px',
})

const styleSelector = (style) => {
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
}
</script>
