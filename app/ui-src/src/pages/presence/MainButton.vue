<template>
  <div class="col-12">
    <div class="q-gutter-xs">
      <q-btn color="deep-purple" icon="assessment" 
        class="q-pl-sm mobile-hide" :label="$t('absensi_jurnal')"
        v-if="showJournalBtn"
        @click="showJournalForm"
      />
      <q-btn-dropdown v-if="presenceButtons" color="info" icon="bookmark_add" class="q-pl-sm" :label="$t('aksi')">
        <q-list>
          <q-item clickable v-close-popup>
            <q-item-section>
              <q-item-label>{{ $t('absensi_hadir') }}</q-item-label>
            </q-item-section>
          </q-item>
          <q-item clickable v-close-popup>
            <q-item-section>
              <q-item-label>{{ $t('absensi_sakit') }}</q-item-label>
            </q-item-section>
          </q-item>
          <q-item clickable v-close-popup>
            <q-item-section>
              <q-item-label>{{ $t('absensi_izin') }}</q-item-label>
            </q-item-section>
          </q-item>
          <q-separator />
          <q-item clickable v-close-popup>
            <q-item-section>
              <q-item-label>{{ $t('absensi_alfa') }}</q-item-label>
            </q-item-section>
          </q-item>
        </q-list>
      </q-btn-dropdown>
      <q-btn-dropdown color="teal-9" icon="print" class="q-pl-sm" :label="printLabel">
        <q-list>
          <q-item clickable v-close-popup>
            <q-item-section>
              <q-item-label>{{ $t('absensi_cetak_jurnal') }}</q-item-label>
            </q-item-section>
          </q-item>
          <q-item clickable v-close-popup>
            <q-item-section>
              <q-item-label>{{ $t('absensi_cetak_absen') }}</q-item-label>
            </q-item-section>
          </q-item>
        </q-list>
      </q-btn-dropdown>
      <q-btn color="negative" icon="info" class="q-pl-sm mobile-hide" :label="$t('absensi_arsip_jurnal')"
         />
      <q-btn color="teal" icon="arrow_back" class="q-pl-sm mobile-hide" :label="$t('kelas_kembali')"
        @click="backToClassList()" />
    </div>

    <q-page-sticky position="bottom-right" 
      :offset="fabPos" 
      class="mobile-only force-elevated">
      <q-fab color="primary" icon="keyboard_arrow_up" direction="up">
        <q-fab-action color="deep-purple" icon="assessment" v-if="showJournalBtn"
           />
        <q-fab-action color="negative" icon="info"
           />
        <q-fab-action color="teal" 
          @click="backToClassList()" icon="arrow_back" />
      </q-fab>
    </q-page-sticky>
  </div>
</template>

<script>
import { fabPos } from 'src/composables/fab'
import { useQuasar } from 'quasar'
import { useI18n } from 'vue-i18n'
import { mapState, useStore } from 'vuex'
import { useRouter } from 'vue-router'

export default {
  name: 'MainButton',
  computed: {
    ...mapState('presence', {
      presenceButtons: state => state.presenceButtons,
      showJournalBtn: state => state.showJournalBtn,
    })
  },
  setup() {
    const $q = useQuasar()
    const { t } = useI18n()
    const router = useRouter()
    const store = useStore()

    const backToClassList = () => {
      router.push('/presence')
      store.state.presence.scheduleID = ''
      store.state.presence.showJournalBtn = false
    }

    return {
      fabPos,
      printLabel: $q.screen.lt.sm ? '' : t('absensi_cetak_laporan'),
      backToClassList,
      showJournalForm: () => store.state.presence.showJournalForm = true
    }
  }
}
</script>