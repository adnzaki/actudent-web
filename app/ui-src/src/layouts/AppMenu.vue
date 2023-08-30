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
      />

      <!-- Master Data Menu -->
      <q-expansion-item
        expand-separator
        icon="o_inventory_2"
        label="Data"
        v-if="$q.cookies.get(conf.userType) === '1'"
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
        <menu-item icon="list" :label="$t('menu_jadwal')" link="/schedules" />
        <menu-item
          icon="task_alt"
          :label="$t('menu_kehadiran')"
          link="/presence"
        />
        <menu-item icon="today" :label="$t('menu_agenda')" link="/agenda" />
        <!-- <menu-item icon="restore" :label="$t('menu_post')" link="" /> -->
      </div>
      <menu-item
        icon="o_book"
        :label="$t('menu_jadwal_guru')"
        v-if="$q.cookies.get(conf.userType) === '2'"
        link="/teacher/presence"
      />
      <div
        v-if="
          $q.cookies.get(conf.userType) === '2' ||
          $q.cookies.get(conf.userType) === '0'
        "
      >
        <menu-item
          icon="today"
          :label="$t('menu_agenda')"
          link="/teacher/agenda"
        />
        <!-- <menu-item icon="restore" :label="$t('menu_timeline')" link="" /> -->
      </div>
      <menu-item icon="list_alt" :label="$t('menu_post')" link="/post" />

      <!-- Report Menu -->
      <q-expansion-item
        expand-separator
        icon="o_summarize"
        :label="$t('laporan')"
        v-if="$q.cookies.get(conf.userType) === '2' && isHomeroomTeacher"
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
      >
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
        <!-- <submenu-item :label="$t('menu_feedback')" link="" /> -->
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

    const dashboardLink =
      $q.cookies.get(conf.userType) === '1' ? '/home' : '/teacher/home'

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
    const appSettingsLink =
      $q.cookies.get(conf.userType) === '1'
        ? '/app-settings'
        : '/teacher/app-settings'

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
