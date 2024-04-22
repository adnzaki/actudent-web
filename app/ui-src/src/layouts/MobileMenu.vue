<template>
  <q-footer elevated v-if="$q.screen.lt.sm">
    <q-tabs align="center" v-model="activeMobileMenu" class="text-white">
      <q-route-tab :name="dashboardLink" icon="o_home" :to="dashboardLink" />

      <q-route-tab
        v-if="$q.cookies.get(conf.userType) === '1'"
        to="/schedules"
        name="schedules"
        icon="list"
      />
      <q-route-tab
        v-if="$q.cookies.get(conf.userType) === '2'"
        to="/teacher/presence"
        name="schedules"
        icon="list"
      />
      <q-route-tab
        v-if="
          $q.cookies.get(conf.userType) === '2' ||
          $q.cookies.get(conf.userType) === '0'
        "
        to="/teacher/agenda"
        name="agenda"
        icon="today"
      />
      <q-route-tab
        v-if="
          $q.cookies.get(conf.userType) === '2' ||
          $q.cookies.get(conf.userType) === '0'
        "
        to="/post"
        name="post"
        icon="list_alt"
      />
      <q-route-tab
        v-if="$q.cookies.get(conf.userType) === '1'"
        to="/presence"
        name="presence"
        icon="task_alt"
      />
      <q-route-tab
        v-if="$q.cookies.get(conf.userType) === '1'"
        to="/agenda"
        name="agenda"
        icon="today"
      />
      <q-route-tab to="/manage-account" name="account" icon="account_circle" />
    </q-tabs>
  </q-footer>
</template>
<script>
import { useQuasar } from 'quasar'
import { conf, dashboardLink } from '../composables/common'
import { ref } from 'vue'

export default {
  name: 'MobileMenu',
  setup() {
    const $q = useQuasar()

    const activeMobileMenu = ref(dashboardLink)
    return { conf, dashboardLink, activeMobileMenu }
  },
}
</script>
