<template>
  <q-scroll-area style="height: calc(100% - 150px); margin-top: 150px; border-right: 1px solid #ddd">
    <q-list padding>
      <q-item clickable v-ripple to="/home" :active-class="activeClass">
        <q-item-section avatar>
          <q-icon name="home" />
        </q-item-section>

        <q-item-section>
          {{ $t('menu_dashboard') }}
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
        :label="$t('menu_pengaturan')"
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
import { useI18n } from 'vue-i18n'
import { onMounted, ref } from 'vue'

export default {
  name: 'AdminMenu',
  setup() {
    const { t } = useI18n()

    const activeClass = 'bg-teal-1 text-grey-8'
    const masterMenu = ref([])
    const menus = ref([])
    const settings = ref([])

    onMounted(() => {
      setTimeout(() => {
        masterMenu.value = [
          { label: t('menu_parent'), link: '/parent' },
          { label: t('menu_siswa'), link: '/student' },
          { label: t('menu_pegawai'), link: '/employee' },
          { label: t('menu_kelas'), link: '/class' },
          { label: t('menu_ruang'), link: '/rooms' },
          { label: t('menu_mapel'), link: '/lesson' }
        ]    
  
        menus.value = [
          { link: '', icon: 'list', label: t('menu_jadwal') },
          { link: '', icon: 'task_alt', label: t('menu_kehadiran') },
          { link: '', icon: 'today', label: t('menu_agenda') },
          { link: '', icon: 'restore', label: t('menu_timeline') },
          { link: '', icon: 'forum', label: t('menu_pesan') },
          { link: '', icon: 'bookmark_added', label: t('menu_nilai') },
        ]
  
        settings.value = [
          { label: t('menu_pengguna'), link: '' },
          { label: t('menu_aplikasi'), link: '' },
          { label: t('menu_feedback'), link: '' },
        ]          
      }, 2000)
    })    

    return {
      activeClass,
      masterMenu,
      menus,
      settings
    }
  },

}
</script>
