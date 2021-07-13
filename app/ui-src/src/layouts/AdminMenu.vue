<template>
  <q-scroll-area style="height: calc(100% - 150px); margin-top: 150px; border-right: 1px solid #ddd">
    <q-list padding>
      <q-item clickable v-ripple to="/home" :active-class="activeClass">
        <q-item-section avatar>
          <q-icon name="home" />
        </q-item-section>

        <q-item-section>
          {{ lang.menu_dashboard }}
        </q-item-section>
      </q-item>

      <!-- Master Data Menu -->
      <q-expansion-item
        expand-separator
        icon="inventory"
        label="Data"
      >
        <q-item 
          :active-class="activeClass"
          v-for="(item, index) in masterMenu" :key="index"
          clickable v-ripple 
          :inset-level="1" 
          :to="item.link">
          <q-item-section>
            {{ item.label }}
          </q-item-section>
        </q-item>
      </q-expansion-item>

      <!-- Main App Menu -->
      <q-item
        :active-class="activeClass"
        v-for="(item, index) in menus" :key="index"
        clickable v-ripple 
        :to="item.link">
        <q-item-section avatar>
          <q-icon :name="item.icon" />
        </q-item-section>
        <q-item-section>
          {{ item.label }}
        </q-item-section>
      </q-item>

      <!-- Settings Menu -->
      <q-expansion-item
        expand-separator
        icon="settings"
        :label="lang.menu_pengaturan"
      >
        <q-item 
          :active-class="activeClass"
          v-for="(item, index) in settings" :key="index"
          clickable v-ripple 
          :inset-level="1" 
          :to="item.link">
          <q-item-section>
            {{ item.label }}
          </q-item-section>
        </q-item>
      </q-expansion-item>

    </q-list>
  </q-scroll-area>
</template>
<script>
export default {
  name: 'AdminMenu',
  data() {
    return {
      masterMenu: [],
      menus: [],
      settings: [],
      activeClass: 'bg-teal-1 text-grey-8'
    }
  },
  mounted() {
    setTimeout(() => {
      this.fetchLang('Admin')
      setTimeout(() => {
        this.masterMenu = [
          { label: this.lang.menu_parent, link: '/parent' },
          { label: this.lang.menu_siswa, link: '/student' },
          { label: this.lang.menu_pegawai, link: '/employee' },
          { label: this.lang.menu_kelas, link: '' },
          { label: this.lang.menu_ruang, link: '' },
          { label: this.lang.menu_mapel, link: '' }
        ]    

        this.menus = [
          { link: '', icon: 'list', label: this.lang.menu_jadwal },
          { link: '', icon: 'task_alt', label: this.lang.menu_kehadiran },
          { link: '', icon: 'today', label: this.lang.menu_agenda },
          { link: '', icon: 'restore', label: this.lang.menu_timeline },
          { link: '', icon: 'forum', label: this.lang.menu_pesan },
          { link: '', icon: 'bookmark_added', label: this.lang.menu_nilai },
        ]

        this.settings = [
          { label: this.lang.menu_pengguna, link: '' },
          { label: this.lang.menu_aplikasi, link: '' },
          { label: this.lang.menu_feedback, link: '' },
        ]   
      }, 1000);
    }, 1000)
  },

}
</script>
