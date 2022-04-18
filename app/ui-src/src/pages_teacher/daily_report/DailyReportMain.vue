<template>
  <div :class="wrapperPadding()">    
    <q-card class="my-card">
      <q-card-section>
        <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ $t('absensi_laporan_harian') }}</div>
        <div class="text-h6 text-capitalize" v-else>{{ $t('absensi_laporan_harian') }}</div>
        <div :class="['row', titleSpacing()]">
          <date-selector />
          <div class="col-12 col-sm-6 q-mt-md">
            <q-btn-dropdown color="deep-purple" class="q-pl-lg"
              style="width: 100%;" 
              icon="print" 
              :label="$t('absensi_cetak_laporan')"
              @click="$store.dispatch('presence/getPeriodSummary')">
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
        </div>
      </q-card-section>

    </q-card>
  </div>
</template>

<script>
import { useStore } from 'vuex'
import { useQuasar } from 'quasar'
import { useI18n } from 'vue-i18n'
import { wrapperPadding, titleSpacing } from 'src/composables/screen'
import DateSelector from './DateSelector.vue'
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import { conf } from 'src/composables/common'

export default {
  name: 'DailyReportMain',
  components: {
    DateSelector   
  },
  setup() {
    const store = useStore()
    const $q = useQuasar()
    const route = useRoute()
    const { t } = useI18n()
    store.state.presence.isTeacherSection = true
    const isTeacherSection = computed(() => store.state.presence.isTeacherSection)

    const exportReportUrl = type => { // type = "jurnal" | "absen"
      const params = {
        grade_id: isTeacherSection.value ? localStorage.getItem('grade_id') : route.params.id,
        day: store.state.presence.helper.activeDay === '' 
             ? localStorage.getItem('date') 
             : store.state.presence.helper.activeDay,
        date: store.state.presence.helper.activeDate,
        token: $q.cookies.get(conf.cookieName)
      }

      const { grade_id, day, date, token } = params
      
      return `${conf.adminAPI}absensi/ekspor-${type}/${grade_id}/${day}/${date}/${token}`
    }
    
    return { 
      exportReportUrl,
      wrapperPadding, 
      titleSpacing 
    }
  }
}
</script>
