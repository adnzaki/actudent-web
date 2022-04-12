<template>
  <q-scroll-area style="height: calc(100% - 150px); margin-top: 150px; border-right: 1px solid #ddd">
    <q-list padding>
      <q-item clickable v-ripple :to="dashboardLink" :active-class="activeClass">
        <q-item-section avatar>
          <q-icon name="o_home" />
        </q-item-section>

        <q-item-section>
          {{ $t('menu_dashboard') }}
        </q-item-section>
      </q-item>

      <!-- Master Data Menu -->
      <q-expansion-item
        expand-separator
        icon="o_inventory_2"
        label="Data"
        v-if="$q.cookies.get(conf.userType) === '1'"
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
        v-for="(item, index) in menus[$q.cookies.get(conf.userType)]" :key="index"
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
        icon="o_settings"
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
import { onMounted, ref, watch } from 'vue'
import { conf } from 'src/composables/common'
import { useQuasar } from 'quasar'
import { headerColor } from '../composables/mode'

export default {
  name: 'AppMenu',
  setup() {
    const { t } = useI18n()
    const $q = useQuasar()

    const activeClass = ref('') 
    const masterMenu = ref([])
    const adminMenu = ref([])
    const teacherMenu = ref([])
    const menus = ref({})

    const settings = ref([])

    const dashboardLink = $q.cookies.get(conf.userType) === '1'
                        ? '/home'
                        : '/teacher/home'

    function activeMenuTrigger() {
      if(headerColor.value === 'dark') {
        activeClass.value = 'bg-blue-grey-8 text-grey-3'
      } else {
        activeClass.value = 'bg-teal-1 text-grey-8'
      }  
    }
    watch(headerColor, activeMenuTrigger)

    onMounted(() => {
      activeMenuTrigger()
      setTimeout(() => {
        masterMenu.value = [
          { label: t('menu_parent'), link: '/parent' },
          { label: t('menu_siswa'), link: '/student' },
          { label: t('menu_pegawai'), link: '/employee' },
          { label: t('menu_kelas'), link: '/class' },
          { label: t('menu_ruang'), link: '/rooms' },
          { label: t('menu_mapel'), link: '/lesson' }
        ]    
  
        adminMenu.value = [
          { link: '/schedules', icon: 'list', label: t('menu_jadwal') },
          { link: '/presence', icon: 'task_alt', label: t('menu_kehadiran') },
          { link: '', icon: 'today', label: t('menu_agenda') },
          { link: '', icon: 'restore', label: t('menu_timeline') },
          { link: '', icon: 'o_forum', label: t('menu_pesan') },
        ]

        teacherMenu.value = [
          { link: '/teacher/presence', icon: 'o_book', label: t('menu_jadwal_guru') },
          { link: '', icon: 'today', label: t('menu_agenda') },
          { link: '', icon: 'restore', label: t('menu_timeline') },
          { link: '', icon: 'o_forum', label: t('menu_pesan') },
        ]

        menus.value = {
          '1': adminMenu.value, '2': teacherMenu.value
        }
  
        settings.value = [
          { label: t('menu_aplikasi'), link: '' },
          { label: t('menu_feedback'), link: '' },
        ]          

        if($q.cookies.get(conf.userType) === '1') {
          settings.value.unshift({
            label: t('menu_pengguna'), link: ''
          })
        }
      }, 2000)
    })    

    return {
      dashboardLink,
      activeClass,
      masterMenu,
      menus,
      settings,
      conf
    }
  },

}
</script>
