<template>
  <q-scroll-area
    class="menu-list"
    style="
      height: calc(100% - 150px);
      margin-top: 150px;
      border-right: 1px solid #ddd;
    "
  >
    <q-list padding>
      <menu-item
        icon="o_home"
        :label="$t('menu_dashboard')"
        :link="dashboardLink"
        v-if="$q.screen.gt.xs"
      />

      <!-- Master Data Menu -->
      <q-expansion-item
        expand-separator
        icon="o_inventory_2"
        label="Data"
        v-if="$q.cookies.get(conf.userType) === '1'"
        :default-opened="$q.screen.lt.sm"
      >
        <submenu-item :label="$t('menu_parent')" link="/parent" />
        <submenu-item :label="$t('menu_siswa')" link="/student" />
        <submenu-item :label="$t('menu_pegawai')" link="/employee" />
        <submenu-item :label="$t('menu_kelas')" link="/class" />
        <submenu-item :label="$t('menu_ruang')" link="/rooms" />
        <submenu-item :label="$t('menu_mapel')" link="/lesson" />
      </q-expansion-item>

      <!-- Main App Menu -->
      <div v-if="$q.cookies.get(conf.userType) === '1'">
        <menu-item
          icon="list"
          :label="$t('menu_jadwal')"
          link="/schedules"
          v-if="$q.screen.gt.xs"
        />
        <menu-item
          icon="task_alt"
          :label="$t('menu_kehadiran')"
          link="/presence"
          v-if="$q.screen.gt.xs"
        />
        <menu-item
          icon="today"
          :label="$t('menu_agenda')"
          link="/agenda"
          v-if="$q.screen.gt.xs"
        />
        <!-- <menu-item icon="restore" :label="$t('menu_post')" link="" /> -->
      </div>
      <menu-item
        icon="o_book"
        :label="$t('menu_jadwal_guru')"
        v-if="$q.cookies.get(conf.userType) === '2' && $q.screen.gt.xs"
        link="/teacher/presence"
      />
      <div
        v-if="
          ($q.cookies.get(conf.userType) === '2' ||
            $q.cookies.get(conf.userType) === '0') &&
          $q.screen.gt.xs
        "
      >
        <menu-item
          icon="today"
          :label="$t('menu_agenda')"
          link="/teacher/agenda"
        />
        <!-- <menu-item icon="restore" :label="$t('menu_timeline')" link="" /> -->
      </div>
      <menu-item
        icon="task_alt"
        :label="$t('menu_kehadiran')"
        link="/student/presence"
        v-if="$q.cookies.get(conf.userType) === '3' && $q.screen.gt.xs"
      />
      <menu-item
        v-if="$q.cookies.get(conf.userType) === '3' && $q.screen.gt.xs"
        icon="today"
        :label="$t('menu_agenda')"
        link="/student/agenda"
      />
      <menu-item
        icon="list_alt"
        :label="$t('menu_post')"
        link="/post"
        v-if="$q.screen.gt.xs"
      />

      <!-- Report Menu -->
      <q-expansion-item
        expand-separator
        icon="o_summarize"
        :label="$t('laporan')"
        v-if="$q.cookies.get(conf.userType) === '2' && isHomeroomTeacher"
        :default-opened="$q.screen.lt.sm"
      >
        <submenu-item
          :label="$t('absensi_laporan_harian')"
          link="/teacher/daily-report"
        />
        <submenu-item
          :label="$t('absensi_rekap_bulanan')"
          :link="`/teacher/monthly-summary/${gradeId}`"
        />
        <submenu-item
          :label="$t('absensi_rekap_semester')"
          :link="`/teacher/period-summary/${gradeId}`"
        />
      </q-expansion-item>

      <!-- Settings Menu -->
      <q-expansion-item
        expand-separator
        icon="o_settings"
        :label="$t('menu_pengaturan')"
        :default-opened="$q.screen.lt.sm"
      >
        <submenu-item
          v-if="$q.cookies.get(conf.userType) === '1'"
          :label="$t('libur_title')"
          link="/holidays"
        />
        <submenu-item
          v-if="$q.cookies.get(conf.userType) === '1'"
          :label="$t('menu_pengguna')"
          link="/users"
        />
        <submenu-item :label="$t('menu_aplikasi')" :link="appSettingsLink" />
        <submenu-item
          v-if="$q.cookies.get(conf.userType) === '1'"
          :label="$t('app_report_title')"
          link="/report-settings"
        />
      </q-expansion-item>
    </q-list>
  </q-scroll-area>
</template>
<script>
import { onMounted, ref, watch, computed, provide } from 'vue'
import { conf } from 'src/composables/common'
import { useQuasar } from 'quasar'
import { headerColor } from '../composables/mode'
import MenuItem from './MenuItem.vue'
import SubmenuItem from './SubmenuItem.vue'
import { usePresenceStore } from 'src/stores/presence'

export default {
  name: 'AppMenu',
  components: {
    MenuItem,
    SubmenuItem,
  },
  setup() {
    const $q = useQuasar()
    const store = usePresenceStore()

    const activeClass = ref('')

    // provide active class to child component
    provide('activeClass', activeClass)

    const settings = ref([])

    const dashboardLink = computed(() => {
      const userLevel = $q.cookies.get(conf.userType)
      const dashboardUrl = ref('')
      if (userLevel === '1') {
        dashboardUrl.value = '/home'
      } else if (userLevel === '2' || userLevel === '0') {
        dashboardUrl.value = '/teacher/home'
      } else if (userLevel === '3') {
        dashboardUrl.value = '/student/home'
      }

      return dashboardUrl.value
    })

    function activeMenuTrigger() {
      if (headerColor.value === 'dark') {
        activeClass.value = 'bg-blue-grey-8 text-grey-3'
      } else {
        activeClass.value = 'bg-teal-1 text-grey-8'
      }
    }
    watch(headerColor, activeMenuTrigger)
    store.checkHomeroomTeacher()

    const gradeId = localStorage.getItem('grade_id')

    onMounted(() => activeMenuTrigger())

    const appSettingsLink = computed(() => {
      let appSettingUrl = '/app-settings'
      const userType = $q.cookies.get(conf.userType)

      if (userType === '2') appSettingUrl = '/teacher/app-settings'
      else if (userType === '3') appSettingUrl = '/student/app-settings'

      return appSettingUrl
    })

    return {
      isHomeroomTeacher: computed(() => store.isHomeroomTeacher),
      dashboardLink,
      activeClass,
      conf,
      gradeId,
      appSettingsLink,
    }
  },
}
</script>
