<template>
  <div class="col-12">
    <div class="q-gutter-xs">
      <q-btn color="deep-purple" icon="assessment" 
        class="q-pl-sm mobile-hide" :label="$t('absensi_jurnal')"
        v-if="showJournalBtn || isTeacherSection"
        @click="showJournalForm"
      />
      <q-btn-dropdown v-if="presenceButtons" color="info" icon="bookmark_add" class="q-pl-sm" :label="$t('aksi')">
        <q-list>
          <q-item clickable v-close-popup @click="savePresence(1)">
            <q-item-section>
              <q-item-label>{{ $t('absensi_hadir') }}</q-item-label>
            </q-item-section>
          </q-item>
          <q-item clickable v-close-popup @click="savePresence(3)">
            <q-item-section>
              <q-item-label>{{ $t('absensi_sakit') }}</q-item-label>
            </q-item-section>
          </q-item>
          <q-item clickable v-close-popup @click="showPermissionForm">
            <q-item-section>
              <q-item-label>{{ $t('absensi_izin') }}</q-item-label>
            </q-item-section>
          </q-item>
          <q-separator />
          <q-item clickable v-close-popup @click="savePresence(0)">
            <q-item-section>
              <q-item-label>{{ $t('absensi_alfa') }}</q-item-label>
            </q-item-section>
          </q-item>
        </q-list>
      </q-btn-dropdown>
      <q-btn-dropdown color="teal-9" icon="print" class="q-pl-lg" :label="printLabel">
        <q-list>
          <q-item clickable v-close-popup
            :href="exportReportUrl('jurnal')"
            target="_blank">
            <q-item-section>
              <q-item-label>{{ $t('absensi_cetak_jurnal') }}</q-item-label>
            </q-item-section>
          </q-item>
          <q-item clickable v-close-popup
            :href="exportReportUrl('absen')"
            target="_blank">
            <q-item-section>
              <q-item-label>{{ $t('absensi_cetak_absen') }}</q-item-label>
            </q-item-section>
          </q-item>
        </q-list>
      </q-btn-dropdown>
    </div>

    <q-page-sticky position="bottom-right" 
      :offset="fabPos" 
      class="mobile-only force-elevated">
      <q-btn fab icon="add" color="deep-purple" 
        v-if="showJournalBtn"
        @click="showJournalForm" 
      />
    </q-page-sticky>
  </div>
</template>

<script>
import { fabPos } from 'src/composables/fab'
import { useQuasar } from 'quasar'
import { useI18n } from 'vue-i18n'
import { mapState, useStore } from 'vuex'
import { useRouter, useRoute } from 'vue-router'
import { conf, createQueryString } from 'src/composables/common'

export default {
  name: 'MainButton',
  computed: {
    ...mapState('presence', {
      presenceButtons: state => state.presenceButtons,
      showJournalBtn: state => state.showJournalBtn,
      isTeacherSection: state => state.isTeacherSection
    })
  },
  setup() {
    const $q = useQuasar()
    const { t } = useI18n()
    const router = useRouter()
    const route = useRoute()
    const store = useStore()

    const exportReportUrl = type => { // type = "jurnal" | "absen"
      const params = {
        grade_id: route.params.id,
        day: store.state.presence.helper.activeDay,
        date: store.state.presence.helper.activeDate,
        token: $q.cookies.get(conf.cookieName)
      }

      const { grade_id, day, date, token } = params

      return `${conf.adminAPI}absensi/ekspor-${type}/${grade_id}/${day}/${date}/${token}`
    }

    const backToClassList = () => {
      router.push('/presence')
      store.state.presence.scheduleID = ''
      store.state.presence.showJournalBtn = false
    }

    const showPermissionForm = () => {
      store.commit('presence/multiPresence', () => store.state.presence.showPermissionForm = true)   
    }

    const savePresence = status => {
      store.commit('presence/multiPresence', () => store.dispatch('presence/savePresence', { status }))
    }

    return {
      fabPos,
      printLabel: $q.screen.lt.sm ? '' : t('absensi_cetak_laporan'),
      backToClassList,
      showJournalForm: () => store.state.presence.showJournalForm = true,
      showPermissionForm,
      savePresence,
      exportReportUrl,
    }
  }
}
</script>