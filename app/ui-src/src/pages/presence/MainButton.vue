<template>
  <div class="col-12">
    <div class="q-gutter-xs">
      <q-btn
        icon="assessment"
        class="q-pl-sm mobile-hide action-btn"
        :label="$t('absensi_jurnal')"
        v-if="store.showJournalBtn || isTeacherSection"
        @click="showJournalForm"
      />
      <q-btn-dropdown
        v-if="store.presenceButtons"
        color="cyan-6"
        icon="bookmark_add"
        class="q-pl-sm"
        :label="$t('aksi')"
      >
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
      <q-btn-dropdown
        color="teal-6"
        icon="print"
        class="q-pl-lg"
        :label="printLabel"
        v-if="!isTeacherSection"
      >
        <q-list>
          <q-item
            clickable
            v-close-popup
            style="min-width: 200px"
            :href="exportReportUrl('jurnal')"
            target="_blank"
          >
            <q-item-section>
              <q-item-label>{{ $t('absensi_cetak_jurnal') }}</q-item-label>
            </q-item-section>
          </q-item>
          <q-item
            clickable
            v-close-popup
            :href="exportReportUrl('absen')"
            target="_blank"
          >
            <q-item-section>
              <q-item-label>{{ $t('absensi_cetak_absen') }}</q-item-label>
            </q-item-section>
          </q-item>
        </q-list>
      </q-btn-dropdown>
    </div>

    <q-page-sticky
      position="bottom-right"
      :offset="fabPos"
      class="mobile-only force-elevated"
    >
      <q-btn
        fab
        icon="description"
        class="add-btn"
        v-if="store.showJournalBtn || isTeacherSection"
        @click="showJournalForm"
      />
    </q-page-sticky>
  </div>
</template>

<script>
import { computed } from 'vue'
import { useQuasar } from 'quasar'
import { useI18n } from 'vue-i18n'
import { fabPos } from 'src/composables/fab'
import { conf } from 'src/composables/common'
import { useRouter, useRoute } from 'vue-router'
import { usePresenceStore } from 'src/stores/presence'

export default {
  name: 'MainButton',
  setup() {
    const $q = useQuasar()
    const { t } = useI18n()
    const router = useRouter()
    const route = useRoute()
    const store = usePresenceStore()
    const isTeacherSection = computed(() => store.isTeacherSection)

    const exportReportUrl = (type) => {
      // type = "jurnal" | "absen"
      const params = {
        grade_id: isTeacherSection.value
          ? route.params.classId
          : route.params.id,
        day:
          store.helper.activeDay === ''
            ? localStorage.getItem('date')
            : store.helper.activeDay,
        date: store.helper.activeDate,
        token: $q.cookies.get(conf.cookieName),
      }

      const { grade_id, day, date, token } = params

      return `${conf.adminAPI}absensi/ekspor-${type}/${grade_id}/${day}/${date}/${token}`
    }

    const backToClassList = () => {
      router.push('/presence')
      store.scheduleID = ''
      store.showJournalBtn = false
    }

    const showPermissionForm = () => {
      store.multiPresence(() => (store.showPermissionForm = true))
    }

    const savePresence = (status) => {
      store.multiPresence(() => store.savePresence({ status }))
    }

    return {
      store,
      fabPos,
      savePresence,
      exportReportUrl,
      backToClassList,
      isTeacherSection,
      showPermissionForm,
      showJournalForm: () => (store.showJournalForm = true),
      printLabel: $q.screen.lt.sm ? '' : t('absensi_cetak_laporan'),
    }
  },
}
</script>
