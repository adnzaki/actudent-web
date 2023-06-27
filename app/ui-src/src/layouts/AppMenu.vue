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

      <!-- Master Data Menu | for Admin only-->
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

      <!-- SiAbsen Menu for admin -->
      <q-expansion-item
        expand-separator
        icon="o_fact_check"
        :label="$t('menu_siabsen')"
        v-if="$q.cookies.get(conf.userType) === '1'"
      >
        <submenu-item :label="$t('menu_manage_siabsen')" link="/teacher-presence/manage" />
        <submenu-item :label="$t('siabsen_kegiatan')" link="/teacher-presence/events" />

        <!-- Permission menu only -->
        <q-item 
          :active-class="activeClass"
          clickable v-ripple 
          :inset-level="1" 
          to="/teacher-presence/permit">
          <q-item-section>
            {{ $t('absensi_izin') }}
          </q-item-section>
          <q-item-section side v-if="$store.state.siabsen.notifCounter > 0">
            <q-badge :label="$store.state.siabsen.notifCounter" color="red" rounded />
          </q-item-section>
        </q-item>
        <!-- End permission menu -->

        <submenu-item :label="$t('absensi_rekap_bulanan')" link="/teacher-presence/monthly-summary" />
        <submenu-item :label="$t('siabsen_jadwal')" link="/teacher-presence/schedule" />
        <submenu-item :label="$t('menu_pengaturan')" link="/teacher-presence/config" />
      </q-expansion-item>

      <!-- SiAbsen Menu for teacher and staff-->
      <q-expansion-item
        expand-separator
        icon="o_fact_check"
        :label="$t('menu_siabsen_guru')"
        v-if="$q.cookies.get(conf.userType) === '2' || $q.cookies.get(conf.userType) === '0'"
      >
        <submenu-item :label="$t('absensi_izin')" link="/absence/permit" />
        <submenu-item :label="$t('absensi_rekap_bulanan')" link="/absence/monthly-summary" />
        <submenu-item :label="$t('siabsen_kegiatan')" link="/absence/events" />
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
        <menu-item icon="restore" :label="$t('menu_post')" link="" />
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
        <menu-item icon="restore" :label="$t('menu_timeline')" link="" />
      </div>

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
        <submenu-item :label="$t('menu_feedback')" link="" />
      </q-expansion-item>
    </q-list>
  </q-scroll-area>
</template>
<script>
import { onMounted, ref, watch, computed, provide } from "vue";
import { conf } from "src/composables/common";
import { useQuasar } from "quasar";
import { headerColor } from "../composables/mode";
import MenuItem from "./MenuItem.vue";
import SubmenuItem from "./SubmenuItem.vue";
import { usePresenceStore } from "src/stores/presence";

export default {
  name: "AppMenu",
  components: {
    MenuItem,
    SubmenuItem,
  },
  setup() {
    const $q = useQuasar();
    const store = usePresenceStore();

    const activeClass = ref("");

    // provide active class to child component
    provide("activeClass", activeClass);

    const settings = ref([]);

    const dashboardLink =
      $q.cookies.get(conf.userType) === "1" ? "/home" : "/teacher/home";

    function activeMenuTrigger() {
      if (headerColor.value === "dark") {
        activeClass.value = "bg-blue-grey-8 text-grey-3";
      } else {
        activeClass.value = "bg-teal-1 text-grey-8";
      }
    }
    watch(headerColor, activeMenuTrigger);
    store.checkHomeroomTeacher();

    const gradeId = localStorage.getItem("grade_id");

    onMounted(() => activeMenuTrigger());
    const appSettingsLink =
      $q.cookies.get(conf.userType) === "1"
        ? "/app-settings"
        : "/teacher/app-settings";

    return {
      isHomeroomTeacher: computed(() => store.state.presence.isHomeroomTeacher),
      dashboardLink,
      activeClass,
      conf,
      gradeId,
      appSettingsLink,
    };
  },
};
</script>
